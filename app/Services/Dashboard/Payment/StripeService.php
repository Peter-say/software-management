<?php

namespace App\Services\Dashboard\Payment;

use App\Models\HotelSoftware\Guest;
use App\Models\HotelSoftware\HotelUser;
use App\Models\HotelSoftware\WalkInCustomer;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\Dashboard\Payment\PaymentService;

class StripeService
{
    public function charge(Request $request)
    {
        try {
            // Set the secret key for Stripe
            \Stripe\Stripe::setApiKey('sk_test_51NgZJ0CELUDJ3vYZsE8oxanTJgR81YTRKuGAGnO9bZR2jqSepe0pssxqQ395rQfy36kmN1LBR9e26fj24kf6TtqI00JQOtc7yl');
    
            // Ensure you have the correct token
            if (!$request->stripeToken) {
                throw new Exception('Stripe token is missing');
            }
    
            // Get the amount from request
            $amount = $request->input('amount') * 100; // Stripe uses cents
    
            // Get the billing address
            $address = $this->getAddress($request);
    
            // Create the Stripe charge
            $stripeCharge = \Stripe\Charge::create([
                'amount' => $amount,
                'currency' => 'usd', // Change currency if necessary
                'source' => $request->stripeToken,
                'description' => 'Wallet funding',
                'metadata' => [
                    'country' => $address['country'],
                    'line1' => $address['line1'],
                    'state' => $address['state'],
                    'postal_code' => $address['postal_code'],
                ],
            ]);
    
            return $stripeCharge; // Return the charge object if needed
        } catch (\Exception $e) {
            throw new Exception('Stripe payment error: ' . $e->getMessage());
        }
    }
    

    public function getAddress(Request $request)
    {
        // Determine the customer type and retrieve the appropriate model
        $address = [
            'country' => null,
            'line1' => null,
            'state' => null,
            'postal_code' => null,
        ];

        if ($request->has('guest_id')) {
            $guest = Guest::find($request->guest_id);
            if ($guest) {
                $address = [
                    'country' => $guest->country->name ?? null,
                    'line1' => $guest->address ?? null,
                    'state' => $guest->state->name ?? null,
                    'postal_code' => $guest->postal_code ?? null,
                ];
            }
        } elseif ($request->has('user_id')) {
            $user = HotelUser::find($request->user_id);
            if ($user) {
                $address = [
                    'country' => $user->country->name ?? null,
                    'line1' => $user->address ?? null,
                    'state' => $user->state->name ?? null,
                    'postal_code' => $user->postal_code ?? null,
                ];
            }
        } elseif ($request->has('walkin_customer_id')) {
            $walkInCustomer = WalkInCustomer::find($request->walkin_customer_id);
            if ($walkInCustomer) {
                $address = [
                    'country' => $walkInCustomer->country->name ?? null,
                    'line1' => $walkInCustomer->address ?? null,
                    'state' => $walkInCustomer->state->name ?? null,
                    'postal_code' => $walkInCustomer->postal_code ?? null,
                ];
            }
        }

        return $address;
    }
}
