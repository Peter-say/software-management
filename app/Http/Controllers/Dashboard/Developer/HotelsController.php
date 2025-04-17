<?php

namespace App\Http\Controllers\Dashboard\Developer;

use App\Http\Controllers\Controller;
use App\Models\HotelSoftware\Hotel;
use App\Models\HotelSoftware\HotelUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\URL;

class HotelsController extends Controller
{
    public function appStats()
    {
        $total_hotels = Hotel::count();
        $active_hotels = Hotel::where('status', strtolower('active'))->count();
        $inactive_hotels = Hotel::where('status', strtolower('inactive'))->count();
        $total_users = User::count();
        $data = [
            "cards" => [
                [
                    "title" => "Registered Hotels",
                    "value" => $total_hotels,
                    "class" => "primary",
                ],
                [
                    "title" => "Active Hotels",
                    "value" => $active_hotels,
                    "class" => "success",
                ],
                [
                    "title" => "Inactive Hotels",
                    "value" => $inactive_hotels,
                    "class" => "warning",
                ],
                [
                    "title" => "Total Users",
                    "value" => $total_users,
                    "class" => "info",
                ],
            ],

        ];
        return  [$data];
    }
    public function index()
    {
        $hotels = Hotel::latest()->paginate(30);
        return view('dashboard.developer.hotel.index', [
            'hotels' => $hotels
        ]);
    }

    public function show($id)
    {
        $hotel = Hotel::findOrFail($id);
        $hotel_users = HotelUser::where('hotel_id', $hotel->id)->latest()->get();
        return view('dashboard.developer.hotel.show', [
            'hotel' => $hotel,
            'hotel_users' => $hotel_users,
        ]);
    }

    public function delete($id)
    {
        try {
            $hotel = Hotel::findOrFail($id);
            $hotel->delete($id);
            return redirect()->route('dashboard.hotels')->with('success_message', 'Hotel deleted successfully.');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error_message', 'An error occurred while deleting the hotel.' . $e->getMessage());
        }
    }

    public function loginAsHotelOwner(Request $request, $id)
    {
        // Only allow developers to impersonate
        $user = User::getAuthenticatedUser();
        if (!$user || $user->role !== 'Developer') {
            abort(403, 'Unauthorized');
        }
        $hotel_owner = User::findOrFail($id);
        // Generate a temporary signed URL for impersonation valid for 5 minutes
        $impersonationUrl = URL::temporarySignedRoute(
            'dashboard.hotels.impersonate',
            now()->addMinutes(5),
            ['id' => $hotel_owner->id]
        );

        return redirect($impersonationUrl);
    }

    public function impersonate(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $auth_user = User::getAuthenticatedUser();
        session(['impersonator_id' => $auth_user->id]);
        Auth::login($user);

        return redirect()->route('dashboard.home');
    }

    public function switchBackImpersonator(Request $request)
    {
        $impersonatorId = session('impersonator_id');

        if (!$impersonatorId) {
            abort(403, 'No impersonator session found');
        }
        $developer = User::findOrFail($impersonatorId);
        Auth::login($developer);
        session()->forget('impersonator_id');
        return redirect()->route('dashboard.home');
    }
}
