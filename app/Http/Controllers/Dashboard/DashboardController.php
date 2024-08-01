<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\hotelSoftware\Hotel;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        // $hotel = Hotel::where('uuid', $uuid)->firstOrFail();
        return view('dashboard.index', [
            // 'hotel' => $hotel,
        ]);
    }
}
