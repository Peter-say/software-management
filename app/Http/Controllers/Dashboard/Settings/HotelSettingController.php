<?php

namespace App\Http\Controllers\Dashboard\Settings;

use App\Http\Controllers\Controller;
use App\Models\HotelSoftware\HotelCurrency;
use App\Models\HotelSoftware\HotelPaymentPlatform;
use App\Models\HotelSoftware\PaymentPlatform;
use App\Models\User;
use Illuminate\Http\Request;

class HotelSettingController extends Controller
{
    public function index()
    {
        return view('dashboard.settings.hotel.index');
    }

    public function paymentPlaform()
    {
        $payment_platforms = PaymentPlatform::with('hotelPaymentPlatforms')->get();
        $selected_platform = HotelPaymentPlatform::where('hotel_id', User::getAuthenticatedUser()->hotel->id)->first();
        return view('dashboard.settings.hotel.payment-platform', [
            'payment_platforms' => $payment_platforms,
            'selected_platform' => $selected_platform,
        ]);
    }

    public function editCurrency()
    {
        $hotel_currency = HotelCurrency::where('hotel_id', User::getAuthenticatedUser()->hotel->id)->first();
        return view('dashboard.settings.hotel.edit-currency', 
        ['hotel_currency' => $hotel_currency,
    ]);
    }
}
