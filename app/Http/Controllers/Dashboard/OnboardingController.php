<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\hotelSoftware\Hotel;
use App\Models\HotelSoftware\HotelUser;
use App\Models\User;
use App\Services\Dashboard\Onboarding;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

        if ($hotelUser) {
            return redirect()->route('dashboard.home');
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
            return redirect()->route('dashboard.home')->with('success_message', "App set-up completed successfully");
        } catch (Exception $e) {

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
