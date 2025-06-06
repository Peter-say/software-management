<?php

namespace App\Services\Dashboard\Finance\Payment;

use App\Models\HotelSoftware\Guest;
use App\Models\HotelSoftware\HotelPaymentPlatform;
use App\Models\HotelSoftware\HotelUser;
use App\Models\HotelSoftware\WalkInCustomer;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Stripe\Stripe;

class StripeService
{
    protected $payment_platform;
    public function __construct()
    {
        $this->payment_platform = HotelPaymentPlatform::where('hotel_id', User::getAuthenticatedUser()->hotel->id)->first();
    }

    public function getSecreteKey()
    {
        return $this->payment_platform->secret_key;
    }

    public function charge(Request $request)
    {
        try {
          Stripe::setApiKey($this->getSecreteKey());
            if (!$request->stripeToken ?? null) {
                throw new Exception('Stripe token is missing');
            }
            $amount = $request->input('amount') * 100; // Stripe uses cents
            $currency = strtolower(getCountryCurrency());
            $address = $this->getAddress($request);
            $stripeCharge = \Stripe\Charge::create([
                'amount' => $amount,
                'currency' => $currency,
                'source' => $request->stripeToken,
                'description' => $request->description,
                'metadata' => [
                    'country' => $address['country'],
                    'line1' => $address['line1'],
                    'state' => $address['state'],
                    'postal_code' => $address['postal_code'],
                ],
            ]);

            return $stripeCharge;
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
