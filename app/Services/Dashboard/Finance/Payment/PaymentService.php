<?php

namespace App\Services\Dashboard\Finance\Payment;

use App\Constants\CurrencyConstants;
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
            'payment_method' => 'required|string|in:CARD,BANK_TRANSFER,WALLET', // Payment method type (e.g., card, bank transfer) is required
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

    // public function processPayment(Request $request, $payment_id = null)
    // {
    //     return DB::transaction(function () use ($request, $payment_id) {
    //         $data = $this->validatePayment($request->all());
    //        $payable_detail = $this-> processReservationPayment($request);
    //        dd( $payable_detail,  $data);
    //         $data['user_id'] = User::getAuthenticatedUser()->id;
    //         $data['payable_id'] = $request->input('payable_id');
    //         $data['payable_type'] = $request->input('payable_type');
    //         $data['transaction_id'] = 'TXN' . strtoupper(uniqid());
    //         $data['amount'] = $data['amount'] ?? $request->amount;
    //         $data['description'] = $data['description'] ?? $request->description;

    //         if ($request->stripe_payment === 'Stripe') {
    //             // Create the Stripe payment using the Stripe service
    //             $stripeCharge = $this->stripe_service->charge($request);
    //             if ($stripeCharge->status == 'succeeded') {
    //                 $data['status'] = 'completed';
    //                 $data['payment_method_token'] = $request->input('stripeToken');
    //                 $data['currency'] = strtoupper($stripeCharge->currency);
    //                 $data['payment_method'] = strtoupper($stripeCharge->payment_method_details->type ?? 'unknown');
    //             } elseif ($wallet = $request->input('WALLET')) {
    //                 $data['payment_method'] = strtoupper($wallet);
    //             } else {
    //                 throw new Exception('Stripe payment failed: ' . $stripeCharge->failure_message);
    //             }
    //         }
    //         $payment = Payment::create($data);
    //         $statusInfo = $this->evaluatePaymentStatus($data['amount'], $request->total_amount);
    //         $payment->status = $statusInfo['status'];
    //         $payment->save();
    //         return $payment;
    //     });
    // }

    public function processPayment(Request $request, $payment_id = null)
    {
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
                ]);
                // dd($data, $payments );
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

            // Save payments using Eloquent
            foreach ($payments as $payment) {
                $payment->save();
            }
            $payments = Payment::whereIn('transaction_id', collect($payments)->pluck('transaction_id'))->get();

            if ($payments->count() === 1) {
                $payment = $payments->first(); // Extract single model
                $statusInfo = $this->evaluatePaymentStatus($payment->amount, $request->total_amount);
                $payment->status = $statusInfo['status'];
                $payment->save();
            } else {
                $payments->each(function ($payment) use ($request) {
                    $statusInfo = $this->evaluatePaymentStatus($payment->amount, $request->total_amount);
                    $payment->status = $statusInfo['status'];
                    $payment->save();
                });
            }
            
            return $payments;
            
        });
    }

    // public function processReservationPayment(Request $request)
    // {
    //     $payables = $request->input('payables', []);
    //     $submittedAmount = $request->input('amount', 0);

    //     if (empty($payables) || $submittedAmount <= 0) {
    //         throw new Exception('Invalid payment request');
    //     }

    //     $remainingAmount = $submittedAmount;
    //     $processedPayables = [];
    //     $totalOtherPayableAmount = 0;

    //     // First pass: allocate amounts sequentially for reservations
    //     foreach ($payables as $payable) {
    //         $payable = collect($payable);
    //         $payable_amount = $payable->get('payable_amount', 0);

    //         if ($payable->get('payable_type') === 'App\Models\HotelSoftware\RoomReservation') {
    //             $allocatedAmount = min($payable_amount, $remainingAmount);
    //             $processedPayables[] = [
    //                 'payable_id' => $payable->get('payable_id'),
    //                 'payable_type' => $payable->get('payable_type'),
    //                 'allocated_amount' => $allocatedAmount,
    //             ];
    //             $remainingAmount -= $allocatedAmount;
    //         } else {
    //             // Track other payable types for proportional allocation
    //             $totalOtherPayableAmount += $payable_amount;
    //         }

    //         if ($remainingAmount <= 0) {
    //             break; // No more funds to allocate
    //         }
    //     }

    //     // Second pass: allocate proportionally for other payables if funds remain
    //     if ($remainingAmount > 0 && $totalOtherPayableAmount > 0) {
    //         $processedOtherPayables = [];
    //         foreach ($payables as $payable) {
    //             $payable = collect($payable);
    //             $payable_amount = $payable->get('payable_amount', 0);

    //             if ($payable->get('payable_type') !== 'App\Models\HotelSoftware\RoomReservation') {
    //                 $proportionalShare = ($payable_amount / $totalOtherPayableAmount) * $remainingAmount;
    //                 $allocatedAmount = round($proportionalShare, 2); // Round to 2 decimal places

    //                 $processedOtherPayables[] = [
    //                     'payable_id' => $payable->get('payable_id'),
    //                     'payable_type' => $payable->get('payable_type'),
    //                     'allocated_amount' => $allocatedAmount,
    //                 ];

    //                 $remainingAmount -= $allocatedAmount;

    //                 if ($remainingAmount <= 0) {
    //                     break; // Fully allocated
    //                 }
    //             }
    //         }

    //         // Adjust the last allocated item to use up any remaining amount
    //         if ($remainingAmount > 0 && !empty($processedOtherPayables)) {
    //             $lastIndex = count($processedOtherPayables) - 1;
    //             $processedOtherPayables[$lastIndex]['allocated_amount'] += $remainingAmount;
    //             $remainingAmount = 0;
    //         }

    //         $processedPayables = array_merge($processedPayables, $processedOtherPayables);
    //     }

    //     return [
    //         'processed_payables' => $processedPayables,
    //         'remaining_amount' => $remainingAmount, // This should now always be 0
    //     ];
    // }


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

    public function stripCredit() {}

    public function payWithCard(Request $request)
    {
        $this->validatePayment($request->al);
    }
}
