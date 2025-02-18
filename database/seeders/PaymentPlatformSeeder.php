<?php

namespace Database\Seeders;

use App\Models\HotelSoftware\PaymentPlatform;
use Illuminate\Database\Seeder;

class PaymentPlatformSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $platforms = [
            [
                'name' => 'Stripe',
                'slug' => 'stripe',
                'description' => 'Stripe is a powerful online payment processing platform.',
                'base_url' => 'https://api.stripe.com',
                'logo' => 'stripe.png',
                'mode' => 'live',
                'is_active' => true,
            ],
            [
                'name' => 'Paystack',
                'slug' => 'paystack',
                'description' => 'Paystack helps businesses in Africa accept payments easily.',
                'base_url' => 'https://api.paystack.co',
                'logo' => 'paystack.png',
                'mode' => 'live',
                'is_active' => true,
            ],
            [
                'name' => 'Flutterwave',
                'slug' => 'flutterwave',
                'description' => 'Flutterwave provides seamless payment solutions for businesses.',
                'base_url' => 'https://api.flutterwave.com',
                'logo' => 'flutterwave.png',
                'mode' => 'live',
                'is_active' => true,
            ],
        ];

        foreach ($platforms as $platform) {
            PaymentPlatform::updateOrCreate(['slug' => $platform['slug']], $platform);
        }
    }
}
