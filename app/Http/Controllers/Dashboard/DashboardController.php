<?php

namespace App\Http\Controllers\Dashboard;

use App\Services\Dashboard\Hotel\DashboardService;
use App\Http\Controllers\Controller;
use App\Models\hotelSoftware\Hotel;
use App\Models\HotelSoftware\HotelUser;
use App\Models\HotelSoftware\Room;
use App\Models\HotelSoftware\RoomReservation;
use App\Models\User;
use App\Services\Dashboard\Hotel\Chart\DashboardReservationService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $dashboard_service;
    protected $dashboard_reservation_service;
    public function __construct(DashboardService $dashboard_service)
    {
        $this->dashboard_service = $dashboard_service;
        $this->dashboard_reservation_service = new DashboardReservationService();
    }
    public function dashboard(Request $request)
    {
        $period = $request->get('period', 'day');

        $booking_period = $request->get('booking_period', 'week');
      
        if (!in_array($period, ['day', 'week', 'month', 'year'])) {
            $period = 'month';
        }
        if (!in_array($booking_period, ['week', 'year'])) {
            $booking_period = 'week';
        }
        $user = User::getAuthenticatedUser();
        $hotelUser = HotelUser::where('user_id', $user->id)->first();
        // $reservation_analytics = $this->dashboard_reservation_service->stats(['booking_period' => $booking_period]);
        // dd( [$reservation_analytics]);
        if ($hotelUser) {
            return view('dashboard.index', [
                'room_reservation_stats' =>  $this->dashboard_service->stats(['period' => $period]),
                'occupiedRooms' => $this->dashboard_service->countOccupiedRoomsToday(),
                'available_rooms' => $this->dashboard_service->countAvailableRoomsToday(),
                'total_transaction' => $this->dashboard_service->calculateTotalTransaction(),
                'reservation_data' => $this->dashboard_reservation_service->stats(['booking_period' => $booking_period]),
            ]);
        } else {
            return redirect()->route('onboarding.setup-app');
        }
    }
}
