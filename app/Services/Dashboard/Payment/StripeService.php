<?php

namespace App\Services\Dashboard\Payment;

use Exception;
use Illuminate\Http\Request;

class StripeService
{
    protected $payment_service;
    public function __construct(PaymentService $payment_service)
    {
        $this->payment_service = $payment_service;
    }
    public function charge(Request $request)
    {
        try {
            $data = $this->payment_service->validatePayment($request);
            $stripeCharge = \Stripe\Charge::create([
                'amount' => $data['amount'] * 100, // Stripe uses cents
                'currency' => 'usd', // Change currency if necessary
                'source' => $request->stripeToken, // Make sure you pass the stripe token from the front end
                'description' => 'Wallet funding',
            ]);
        } catch (\Exception $e) {
            // Handle error
            throw new Exception('Stripe payment error: ' . $e->getMessage());
        }
    }
}
