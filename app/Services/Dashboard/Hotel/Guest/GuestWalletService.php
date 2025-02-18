<?php

namespace App\Services\Dashboard\Hotel\Guest;

use App\Models\HotelSoftware\BarOrder;
use App\Models\Payment;
use App\Models\Transaction;
use App\Models\HotelSoftware\Guest;
use App\Models\HotelSoftware\GuestPayment;
use App\Models\HotelSoftware\RestaurantOrder;
use App\Models\HotelSoftware\RoomReservation;
use App\Services\Dashboard\Finance\Payment\PaymentService;
use App\Services\Dashboard\Finance\Transaction\TransactionService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GuestWalletService
{
    protected $payment_service;
    protected $transaction_service;

    public function __construct(PaymentService $payment_service, TransactionService $transaction_service)
    {
        $this->payment_service = $payment_service;
        $this->transaction_service = $transaction_service;
    }

    protected function validateData(Request $request)
    {
        return $request->validate([
            'guest_id' => 'nullable|exists:guests,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string|in:CARD,BANK_TRANSFER,WALLET',
            'description' => 'nullable|string',
        ]);
    }



    public function getReservationById($id)
    {
        $reservation = RoomReservation::find($id);
        if (empty($reservation)) {
            throw new ModelNotFoundException("Reservation not found with ID: {$id}");
        }
        return $reservation;
    }
    public function getOrderById($id)
    {
        $order = RestaurantOrder::find($id);
        if (empty($order)) {
            throw new ModelNotFoundException("Order not found with ID: {$id}");
        }
        return $order;
    }

    public function getBarOrderById($id)
    {
        $order = BarOrder::find($id);
        if (empty($order)) {
            throw new ModelNotFoundException("Order not found with ID: {$id}");
        }
        return $order;
    }


    public function recordCreditTransaction(Request $request)
    {
        // dd($request->all());
        DB::beginTransaction();

        try {
            // Validate the credit transaction data
            $validatedData = $this->validateData($request);
            // Process the payment
            $payment = $this->payment_service->processPayment($request);
            // Process the transaction using the existing payment
            $transaction = $this->transaction_service->processTransaction($request, $payment);
            $transaction->transaction_type = 'credit';

            // Link the transaction to the payment
            $payment->transactions()->save($transaction);

            $guest = Guest::find($request->guest_id);
            // Update the wallet balance from the request
            $guestWallet = $guest->wallet;
            $guestWallet->balance += $validatedData['amount'];
            $guestWallet->save();

            DB::commit();

            return $guestWallet; // Return the updated wallet
        } catch (Exception $e) {
            DB::rollBack(); // Rollback the transaction on failure
            throw $e; // Rethrow the exception to be handled in the controller
        }
    }

    public function recordDebitTransaction(Request $request)
    {
        $validatedData = $this->validateData($request);

        DB::beginTransaction();
        $guest = Guest::findOrFail($validatedData['guest_id']);

        if ($validatedData['amount'] > $guest->wallet->balance) {
            throw new \Exception('Insufficient balance to deduct from.');
        }

        $payment = $guest->walletPayments()->create([
            'user_id' => $guest->user_id,
            'amount' => $validatedData['amount'],
            'payment_method' => 'WALLET',
            'description' => $validatedData['note'],
            'status' => 'completed',
            'transaction_id' => 'TXN' . time(),
        ]);

        $guest->wallet->balance -= $validatedData['amount'];
        $guest->wallet->save();

        $transaction = new Transaction([
            'amount' => $validatedData['amount'],
            'transaction_type' => 'debit',
            'status' => 'completed',
            'description' => $validatedData['note'],
            'transaction_reference' => $payment->transaction_id,
        ]);
        $payment->transactions()->save($transaction);

        DB::commit();
        return $payment;
    }

    public function payWithGuestWallet(Request $request)
    {
        return DB::transaction(function () use ($request) {
            $validatedData = $this->validateData($request);
            $guest = null;
            $reservation = null;
            $order = null;
            if ($request->has('reservation_id')) {
                $reservation = $this->getReservationById($request->input('reservation_id'));
                if ($reservation) {
                    $guest = $reservation->guest;
                }
            }
            if ($request->has('order_id')) {
                $order = $this->getOrderById($request->input('order_id'));
                if ($order) {
                    $guest = $order->guest;
                }
            }
            if ($validatedData['amount'] > $guest->wallet->balance) {
                throw new \Exception('Insufficient balance to deduct from.');
            }
            $payments = $this->payment_service->processPayment($request);
            if ($payments instanceof \Illuminate\Database\Eloquent\Collection) {
                $payment = $payments->first();
                $transaction = $this->transaction_service->processTransaction($request, $payment);
                $transaction->transaction_type = 'debit';
                $payment->transactions()->save($transaction);
            } else {
                foreach ($payments as $payment) {
                    $transaction = $this->transaction_service->processTransaction($request, $payment);
                    $transaction->transaction_type = 'debit';
                    $payment->transactions()->save($transaction);
                }
            }

            $guest->wallet->balance -= $validatedData['amount'];
            $guest->wallet->save();
            GuestPayment::create([
                'guest_id' => $guest->id,
            ]);

            if ($reservation) {
                $this->updateReservationStatus($reservation, $validatedData['amount']);
            }
            if ($order) {
                $this->updateOrderStatus($order, $validatedData['amount']);
            }
            return $payment;
        });
    }


    protected function updateReservationStatus($reservation, $amount)
    {
        $reservation_payments = ($reservation->payments() ?? collect())->sum('amount');
        $total_paid = $reservation_payments + $amount;
        if ($total_paid >= $reservation->total_amount) {
            $reservation->payment_status = 'confirmed';
        } elseif ($total_paid > 0 && $total_paid < $reservation->total_amount) {
            $reservation->payment_status = 'partial';
        } else {
            $reservation->payment_status = 'pending';
        }
        $reservation->save();
        return $reservation->payment_status;
    }

    protected function updateOrderStatus($order, $amount)
    {
        $order_payments = $order->payments()->sum('amount');
        $total_paid = $order_payments + $amount;
        if ($total_paid >= $order->total_amount) {
            $order->status = 'closed';
            RestaurantOrder::where('id', '!=', $order->id)
                ->whereHas('payments', function ($query) {
                    $query->havingRaw('SUM(amount) >= total_amount');
                })
                ->update(['status' => 'closed']);
            BarOrder::where('id', '!=', $order->id)
                ->whereHas('payments', function ($query) {
                    $query->havingRaw('SUM(amount) >= total_amount');
                })
                ->update(['status' => 'closed']);
        } elseif ($total_paid > 0) {
            $order->status = 'open';
        } else {
            $order->status = 'open';
        }
        $order->save();
        return $order->status;
    }
}
