<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\hotelSoftware\Hotel;
use App\Models\HotelSoftware\HotelUser;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $user = User::getAuthenticatedUser();
        // Check if the user is associated with any hotel
        $hotelUser = HotelUser::where('user_id', $user->id)->first();

        if ($hotelUser) {
            return view('dashboard.index', [
                // 'hotel' => $hotel,
            ]);
        } else {
            return redirect()->route('onboarding.setup-app');
        }
    }
}
