<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\hotelSoftware\Hotel;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        if (auth()->user()->hotel) {
            // $hotel = Hotel::where('uuid', $uuid)->firstOrFail();
            return view('dashboard.index', [
                // 'hotel' => $hotel,
            ]);
        } else {
            return redirect()->route('onboarding.setup-app');
        }
    }
}
