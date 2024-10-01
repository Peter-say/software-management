<?php

namespace App\Services\Dashboard\Hotel\Guest;

use App\Models\Payment;
use App\Models\Transaction;
use App\Models\HotelSoftware\Guest;
use App\Models\hotelSoftware\GuestPayment;
use App\Models\HotelSoftware\RoomReservation;
use App\Services\Dashboard\Payment\PaymentService;
use App\Services\Dashboard\Transaction\TransactionService;
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

    protected function validateCreditTransaction(Request $request)
    {
        return $request->validate([
            'guest_id' => 'required|exists:guests,id',
            'amount' => 'required|numeric|min:0',
            'mode_of_payment' => 'required',
            'note' => 'nullable|string',
        ]);
    }

    protected function validateDebitTransaction(Request $request)
    {
        return $request->validate([
            'guest_id' => 'required|exists:guests,id',
            'amount' => 'required|numeric|min:0',
            'note' => 'nullable|string',
        ]);
    }

    protected function validatePayWithGuestWallet(Request $request)
    {
        return $request->validate([
            // 'guest_id' => 'required|exists:guests,id',
            'reservation_id' => 'required|exists:room_reservations,id',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'nullable|string',

        ]);
    }

    public function getById($id)
    {
        $reservation = RoomReservation::find($id);
        if (empty($reservation)) {
            throw new ModelNotFoundException("Reservation not found");
        }
        return $reservation;
    }

    public function recordCreditTransaction(Request $request)
    {
        dd($request->all());
        DB::beginTransaction();
        $validatedData = $this->validateCreditTransaction($request);
        dd($validatedData);
        $guest = Guest::findOrFail($validatedData['guest_id']);
        dd($guest);
        // Process the payment
        $payment = $this->payment_service->processPayment($request);
        dd($payment);
        // Process the transaction using the existing payment
        $transaction = $this->transaction_service->processTransaction($request, $payment);
        dd($transaction);
        $transaction->transaction_type = 'credit';
        // Link the transaction to the payment
        $payment->transactions()->save($transaction);

        // Deduct the amount from the guest's wallet
        $guest->wallet->balance += $validatedData['amount'];
        $guest->wallet->save();

        DB::commit();
        return $guest;
    }

    public function recordDebitTransaction(Request $request)
    {
        $validatedData = $this->validateDebitTransaction($request);

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
            $validatedData = $this->validatePayWithGuestWallet($request);

            // Retrieve the guest and reservation
            $reservation = $this->getById($request->input('reservation_id'));
            $guest = $reservation->guest;
            $guest['guest_id'] = $guest->id;

            // Check for sufficient balance
            if ($validatedData['amount'] > $guest->wallet->balance) {
                throw new \Exception('Insufficient balance to deduct from.');
            }

            // Process the payment
            $payment = $this->payment_service->processPayment($request);
            // Process the transaction using the existing payment
            $transaction = $this->transaction_service->processTransaction($request, $payment);

            $transaction->transaction_type = 'debit';
            // Link the transaction to the payment
            $payment->transactions()->save($transaction);

            // Deduct the amount from the guest's wallet
            $guest->wallet->balance -= $validatedData['amount'];
            $guest->wallet->save();

            // set guest payment ID
            GuestPayment::create([
                'guest_id' => $guest->id,
            ]);

            // Update reservation status and save
            $this->updateReservationStatus($reservation, $validatedData['amount']);

            return $payment;
        });
    }


    protected function updateReservationStatus($reservation, $amount)
    {
        // Sum all the payments made for the reservation so far
        $reservation_payments = ($reservation->payments() ?? collect())->sum('amount');

        // Calculate the total paid, including the new amount
        $total_paid = $reservation_payments + $amount;

        // Check if the total paid matches the total amount
        if ($total_paid >= $reservation->total_amount) {
            $reservation->payment_status = 'confirmed';  // Full payment made or overpaid
        } elseif ($total_paid > 0 && $total_paid < $reservation->total_amount) {
            $reservation->payment_status = 'partial';  // Partial payment made
        } else {
            $reservation->payment_status = 'pending';  // No payment or invalid payment
        }

        // Update the reservation with the new payment status
        $reservation->save();

        // Return the updated payment status
        return $reservation->payment_status;
    }
}
