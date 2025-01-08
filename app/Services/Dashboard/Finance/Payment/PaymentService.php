<?php

namespace App\Services\Dashboard\Finance\Payment;

use App\Constants\CurrencyConstants;
use App\Models\Payment;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
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

    public function processPayment(Request $request, $payment_id = null)
    {
        // dd('ddd');
        return DB::transaction(function () use ($request, $payment_id) {
            $data = $this->validatePayment($request->all());
            $data['user_id'] = User::getAuthenticatedUser()->id;
            $data['payable_id'] = $request->input('payable_id');
            $data['payable_type'] = $request->input('payable_type');
            $data['transaction_id'] = 'TXN' . strtoupper(uniqid());
            $data['amount'] = $request->amount;
            $data['description'] = $request->description;
            if ($request->stripe_payment === 'Stripe') {
                // Create the Stripe payment using the Stripe service
                $stripeCharge = $this->stripe_service->charge($request);
                if ($stripeCharge->status == 'succeeded') {
                    $data['status'] = 'completed';
                    $data['payment_method_token'] = $request->input('stripeToken');
                    $data['currency'] = strtoupper($stripeCharge->currency);
                    $data['payment_method'] = strtoupper($stripeCharge->payment_method_details->type ?? 'unknown');
                } elseif ($wallet = $request->input('WALLET')) {
                    $data['payment_method'] = strtoupper($wallet);
                } else {
                    throw new Exception('Stripe payment failed: ' . $stripeCharge->failure_message);
                }
            }
            $payment = Payment::create($data);
            $statusInfo = $this->evaluatePaymentStatus($data['amount'], $request->total_amount);
            $payment->status = $statusInfo['status'];
            $payment->save();
            return $payment;
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

    public function stripCredit() {}

    public function payWithCard(Request $request)
    {
        $this->validatePayment($request->al);
    }
}
