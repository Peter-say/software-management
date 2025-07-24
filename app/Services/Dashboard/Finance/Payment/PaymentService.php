<?php

namespace App\Services\Dashboard\Finance\Payment;

use App\Constants\CurrencyConstants;
use App\Models\HotelSoftware\BarOrder;
use App\Models\HotelSoftware\RestaurantOrder;
use App\Models\HotelSoftware\RoomReservation;
use App\Models\Payment;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class PaymentService
{
    protected $stripe_service;

    public function __construct(StripeService $stripe_service)
    {
        $this->stripe_service = $stripe_service;
    }

    public function validatePayment(array $data)
    {
        $validator = Validator::make($data, [
            'amount' => 'required|numeric|min:1', // Amount is required and must be a positive number
            'currency' => 'nullable|string',
            Rule::in(CurrencyConstants::CURRENCY_CODES), // Currency is nullable and must be one of the allowed currencies if provided
            'payment_method' => 'required|string|in:CARD,BANK_TRANSFER,WALLET,CASH', // Payment method type (e.g., card, bank transfer) is required
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
    public function messages()
    {
        return [
            'currency.in' => 'The selected currency is invalid. Please choose from the allowed currencies.',
        ];
    }

    public function getById($id)
    {
        $payment = Payment::find($id);
        if (empty($payment)) {
            throw new ModelNotFoundException("Payment not found");
        }
        return $payment;
    }

    public function processPayment(Request $request, $payment_id = null)
    {
        // dd($request->all());
        return DB::transaction(function () use ($request, $payment_id) {
            $this->validatePayment($request->all());

            $data = $request->all();
            $data['user_id'] = Auth::id();
            $payables = $request->input('payables');
            // Use a regular array to hold payments
            $payments = [];
            if (!empty($payables)) {
                foreach ($payables as $payable) {
                    $payable_type = $payable['payable_type'];
                    $payable_id = $payable['payable_id'];
                    $payable_amount = $payable['payable_amount'];

                    if (in_array($payable_type, [
                        'App\Models\HotelSoftware\RoomReservation',
                        'App\Models\HotelSoftware\BarOrder',
                        'App\Models\HotelSoftware\RestaurantOrder'
                    ])) {
                        $payments[] = new Payment([
                            'payable_id' => $payable_id,
                            'payable_type' => $payable_type,
                            'amount' => $payable_amount,
                            'transaction_id' => 'TXN' . strtoupper(uniqid()),
                            'user_id' => $data['user_id'],
                        ]);
                    }
                }
            } else {
                // Handle single payment case
                $payments[] = new Payment([
                    'payable_id' => $request->input('payable_id'),
                    'payable_type' => $request->input('payable_type'),
                    'amount' => $request->input('amount'),
                    'transaction_id' => 'TXN' . strtoupper(uniqid()),
                    'user_id' => $data['user_id'],
                    'payment_method' => $request->input('payment_method'),
                    'description' => $request->input('description', ''),
                    'currency' => $request->input('currency', 'USD'),
                ]);
            }

            // Handle Stripe Payment
            if ($request->stripe_payment === 'Stripe') {
                $stripeCharge = $this->stripe_service->charge($request);

                if ($stripeCharge->status === 'succeeded') {
                    foreach ($payments as &$payment) {
                        $payment->status = 'completed';
                        $payment->payment_method_token = $request->input('stripeToken');
                        $payment->currency = strtoupper($stripeCharge->currency);
                        $payment->payment_method = strtoupper($stripeCharge->payment_method_details->type ?? 'unknown');
                    }
                } else {
                    throw new Exception('Stripe payment failed: ' . ($stripeCharge->failure_message ?? 'Unknown error'));
                }
            }
            foreach ($payments as $payment) {
                $payment->save();
            }
            $payments = Payment::whereIn('transaction_id', collect($payments)->pluck('transaction_id'))->get();

            if ($payments->count() === 1) {
                $payment = $payments->first(); // Extract single model
                $statusInfo = $this->evaluatePaymentStatus($payment->amount, $request->total_amount);
                $payment->status = $statusInfo['status'];
                $payment->save();
                $this->updatePaymentStatusForPayable($payment->payable_type, $payment->payable_id, 'completed');
            } else {
                $payments->each(function ($payment) use ($request) {
                    $statusInfo = $this->evaluatePaymentStatus($payment->amount, $request->total_amount);
                    $payment->status = $statusInfo['status'];
                    $payment->save();
                    $this->updatePaymentStatusForPayable($payment->payable_type, $payment->payable_id, 'completed');
                });
            }
            return $payments;
        });
    }

    /**
     * Evaluate the payment status based on the paid amount and the requested amount.
     *
     * @param float $paidAmount
     * @param float $totalAmount
     * @return array
     */
    public function evaluatePaymentStatus($paidAmount, $totalAmount)
    {
        $status = 'not_paid';
        $color = 'danger'; // Default to red for not paid

        if ($paidAmount >= $totalAmount) {
            $status = 'completed';
            $color = 'success'; // Green for completed
        } elseif ($paidAmount > 0 && $paidAmount < $totalAmount) {
            $status = 'partial';
            $color = 'warning'; // Yellow for partially paid
        }
        return [
            'status' => $status,
            'color' => $color,
            'message' => ucfirst($status),
        ];
    }

    /**
     * Update the payment status of the related payable model (e.g., RoomReservation, BarOrder)
     *
     * @param string $payableType
     * @param int $payableId
     * @param string $status
     */
    public function updatePaymentStatusForPayable($payableType, $payableId, $status)
    {
        $payable = app($payableType)::find($payableId);

        if ($payable) {
            if ($payable instanceof RoomReservation) {
                $payable->payment_status = $status;
                $payable->save();
            } elseif ($payable instanceof BarOrder) {
                $payable->status = $status;
                $payable->save();
            } elseif ($payable instanceof RestaurantOrder) {
                $payable->status = $status;
                $payable->save();
            }
        }
    }

    public function stripCredit() {}

    public function payWithCard(Request $request)
    {
        $this->validatePayment($request->al);
    }

    public function list($request)
    {
        $query = Payment::query();

        if ($request->filled('search')) {
            $search = strtolower(trim($request->search));

            $query->where(function ($q) use ($search) {
                $q->where('transaction_id', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('currency', 'like', "%{$search}%");

                // Match amount exactly (with float conversion)
                if (is_numeric($search)) {
                    $q->orWhere('amount', (float) $search);
                }

                // Search by user name
                $q->orWhereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('name', 'like', "%{$search}%");
                });

                // Search by payable ID
                $q->orWhereHas('payable', function ($payableQuery) use ($search) {
                    $payableQuery->where('id', 'like', "%{$search}%");
                });

                // Search by payable type keywords
                if (str_contains($search, 'restaurant')) {
                    $q->orWhere('payable_type', 'like', '%RestaurantOrder%');
                }

                if (str_contains($search, 'bar')) {
                    $q->orWhere('payable_type', 'like', '%BarOrder%');
                }

                if (str_contains($search, 'guest')) {
                    $q->orWhere('payable_type', 'like', '%Guest%');
                }
            });
        }

        // Sorting
        if ($request->filled('selection')) {
            match ($request->selection) {
                'Newest' => $query->latest(),
                'Oldest' => $query->oldest(),
                'Highest' => $query->orderByDesc('amount'),
                'Lowest' => $query->orderBy('amount'),
                'Paid' => $query->where('status', 'completed'),
                'Pending' => $query->where('status', 'pending'),
                default => null,
            };
        }

        return $query->latest()->paginate(30);
    }
}
