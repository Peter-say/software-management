<?php

namespace App\Http\Controllers\Dashboard\Settings;

use App\Helpers\FileHelpers;
use App\Http\Controllers\Controller;
use App\Models\HotelSoftware\Hotel;
use App\Models\HotelSoftware\HotelCurrency;
use App\Models\HotelSoftware\HotelPaymentPlatform;
use App\Models\HotelSoftware\PaymentPlatform;
use App\Models\User;
use Exception;
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
        return view(
            'dashboard.settings.hotel.edit-currency',
            [
                'hotel_currency' => $hotel_currency,
            ]
        );
    }

    public function edit()
    {
        $user = User::getAuthenticatedUser();
        if (!$user ||$user->role !== 'Developer') {
            abort(403, 'Unauthorized');
        }
        $hotel = $user->hotel;

    if (!$hotel) {
        abort(403, 'Hotel not found or you are Unauthorized to access this section of the website');
    }
        return view(
            'dashboard.settings.hotel.edit-info',
            [
                'hotel' => $hotel,
            ]
        );
    }

    public function update(Request $request)
    {
        try {
            $validated = $request->validate([
                'hotel_name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'required|string|max:20',
                'address' => 'nullable|string|max:255',
                'country_id' => 'nullable|exists:countries,id',
                'state_id' => 'nullable|exists:states,id',
                'website' => 'nullable|url|max:255',
                'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $hotel = Hotel::where('id', User::getAuthenticatedUser()->hotel->id)->first();
            if ($request->hasFile('logo')) {
                $logoDirectory = 'hotel/logos';
                $logoPath = FileHelpers::saveImageRequest($request->file('logo'), $logoDirectory);
                $validatedData['logo'] = basename($logoPath);
                if (!empty($oldlogoPath)) {
                    FileHelpers::deleteFiles([public_path($logoDirectory . '/' . $oldlogoPath)]);
                }
            }
            $hotel->update($validated);
            return redirect()->route('dashboard.hotel.settings.hotel-info.edit')->with('success_message', 'Hotel Info updated');
        } catch (Exception $e) {
            return redirect()->back()->withInput($request->all())->with('error_message', $e->getMessage());
        } catch (\Throwable $th) {
            throw $th;
            return redirect()->back()->with('error_message', 'Something went wrong');
        }
    }
}
