<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\HotelSoftware\HotelModulePreference;
use App\Models\HotelSoftware\HotelUser;
use App\Models\User;
use App\Services\Dashboard\Onboarding;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OnboardingController extends Controller
{
    protected $onboarding;

    public function __construct(Onboarding $onboarding)
    {
        $this->onboarding = $onboarding;
    }

    public function setupApp()
    {
        $user = User::getAuthenticatedUser();

        // Check if the user is associated with any hotel
        $hotelUser = HotelUser::where('user_id', $user->id)->first();
        $hasModules = false;
        if ($hotelUser && $hotelUser->hotel) {
            $hasModules = HotelModulePreference::where('hotel_id', $hotelUser->hotel->id)->exists();
        }
        if ($hasModules) {
            return redirect()->route('dashboard.home');
        } elseif (!$hasModules) {
            return redirect()->route('dashboard.hotel.module-preferences.create');
        } else {
            return view('dashboard.onbaording.onboarding');
        }
    }

    // In your controller method
    public function saveSetupApp(Request $request)
    {
        try {

            $softwareTypeResult = $this->onboarding->validateSoftwareTypeInfo($request);
            if ($softwareTypeResult instanceof \Illuminate\Support\MessageBag) {
                // Handle validation errors
                return redirect()->back()->withErrors($softwareTypeResult)->withInput();
            }
            $this->onboarding->storeSoftwareTypeInfo($request);
            // Validate and save hotel info
            $hotelInfoResult = $this->onboarding->validateHotelInfo($request);
            if ($hotelInfoResult instanceof \Illuminate\Support\MessageBag) {
                // Handle validation errors
                return redirect()->back()->withErrors($hotelInfoResult)->withInput();
            }
            $this->onboarding->saveHotelInfo($request);
            return redirect()->route('dashboard.hotel.module-preferences.create')->with('success_message', "Hotel details set up successfully");
        } catch (Exception $e) {
            throw $e;
            return back()->with('error_message', 'An error occurred while submitting your request. Please try again.');
        }
    }

    public function getStatesByCountry(Request $request)
    {
        $countryId = $request->country_id;

        if ($countryId) {
            // Fetch states by country_id
            $states = DB::table('states')
                ->where('country_id', $countryId)
                ->select('id', 'name')
                ->orderBy('name', 'asc')
                ->get();

            return response()->json(['states' => $states]);
        }

        return response()->json(['states' => []]);
    }
}
