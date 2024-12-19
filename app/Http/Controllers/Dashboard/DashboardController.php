<?php

namespace App\Http\Controllers\Dashboard;

use App\Services\Dashboard\Hotel\DashboardService;
use App\Http\Controllers\Controller;
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
        // $recent_room_reservations = $this->dashboard_service->recentBookingSchedule();
        // dd($recent_room_reservations);
        if ($hotelUser) {
            return view('dashboard.index', [
                'room_reservation_stats' =>  $this->dashboard_service->stats(['period' => $period]),
                'occupiedRooms' => $this->dashboard_service->countOccupiedRoomsToday(),
                'available_rooms' => $this->dashboard_service->countAvailableRoomsToday(),
                'total_transaction' => $this->dashboard_service->calculateTotalTransaction(),
                'reservation_data' => $this->dashboard_reservation_service->stats(['booking_period' => $booking_period]),
                'recent_room_reservations' => $this->dashboard_service->recentBookingSchedule(),
            ]);
        } else {
            return redirect()->route('onboarding.setup-app');
        }
    }

    public function loadRecentReservation(Request $request)
    {
        $page = (int) $request->input('page', 1);
        $recent_room_reservations_ids = $this->dashboard_service->recentBookingSchedule()->pluck('id')->toArray();

        // Fetch the next set of reservations, excluding already loaded ones
        $new_reservations = RoomReservation::where('hotel_id', User::getAuthenticatedUser()->hotel->id)
        ->whereNotIn('id', $recent_room_reservations_ids)
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->latest('created_at')->skip(($page - 1) * 2)
            ->take(2)
            ->get();
        // Check if there are more items to load
        $hasMore = RoomReservation::where('hotel_id', User::getAuthenticatedUser()->hotel->id)->whereNotIn('id', $recent_room_reservations_ids)
            ->count() > $page * 2;

        if ($new_reservations->isEmpty()) {
            return response()->json(['html' => '', 'hasMore' => false]);
        }
        $html = view('dashboard.fragments.dashboard.load-more-booking-schedule', ['recent_room_reservations' => $new_reservations])->render();
        return response()->json(['html' => $html, 'hasMore' => $hasMore]);
    }
}
