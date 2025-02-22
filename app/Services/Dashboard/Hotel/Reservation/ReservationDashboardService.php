<?php

namespace App\Services\Dashboard\Hotel\Reservation;

use App\Models\HotelSoftware\Room;
use App\Models\HotelSoftware\RoomReservation;
use App\Models\Payment;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;

class ReservationDashboardService
{
    public $room_reservation;
    public function __construct()
    {
        $this->room_reservation = new RoomReservation();
    }

    public function stats(array $data = [])
    {
        $period = $data["period"] ?? 'day';

        if (!in_array($period, ['day', 'week', 'month', 'year'])) {
            $period = 'month';
        }

        $room_reservation_data = $this->getDashboardData($period);

        $data = [
            "cards" => [
                [
                    // "icon" => "home",
                    "title" => "Ongoing Reservations",
                    "value" => array_sum($room_reservation_data['ongoingReservations']),
                    "class" => "primary",
                    'period' =>  $period,
                ],
                [
                    // "icon" => "home",
                    "title" => "Total Reservations",
                    "value" => array_sum($room_reservation_data['totalCompletedReservations']),
                    "class" => "primary",
                    'period' =>  $period,
                ],
                [
                    // "icon" => "receipt",
                    "title" => "Check In",
                    "value" => array_sum($room_reservation_data['currentCheckedinReservations']),
                    "class" => "primary",
                    'period' =>  $period,
                ],
                [
                    // "icon" => "home",
                    "title" => "Check Out",
                    "value" => array_sum($room_reservation_data['currentCheckedoutReservations']),
                    "class" => "primary",
                    'period' =>  $period,
                ],

            ],

            "dashboard_data" => $room_reservation_data,
        ];

        return $data;
    }

    public function getDashboardData($period = 'month',)
    {
        // Set the current period and previous period based on the selected period
        switch ($period) {
            case 'day':
                $currentStartDate = Carbon::today();
                $previousStartDate = Carbon::yesterday();
                $interval = 'hour';
                $dataPoints = 24; // 24 hours in a day
                break;
            case 'week':
                $currentStartDate = Carbon::now()->startOfWeek();
                $previousStartDate = Carbon::now()->subWeek()->startOfWeek();
                $interval = 'week';
                $dataPoints = 7; // 7 days in a week
                break;
            case 'month':
                $currentStartDate = Carbon::now()->startOfMonth();
                $previousStartDate = Carbon::now()->subMonth()->startOfMonth();
                $interval = 'month';
                $dataPoints = Carbon::now()->daysInMonth; // Days in the current month
                break;
            case 'year':
                $currentStartDate = Carbon::now()->startOfYear();
                $previousStartDate = Carbon::now()->subYear()->startOfYear();
                $interval = 'year';
                $dataPoints = 12; // 12 months in a year
                break;
            default:
                $currentStartDate = Carbon::now()->startOfMonth();
                $previousStartDate = Carbon::yesterday();
                $interval = 'day';
                $dataPoints = Carbon::now()->daysInMonth;
                break;
        }

        // Debug data points value
        // dd($dataPoints);

        // Fetch the current and previous period data
        $currentData = $this->fetchData($currentStartDate, $interval, $dataPoints);
        $previousData = $this->fetchData($previousStartDate, $interval, $dataPoints);


        return [
            'ongoingReservations' => $currentData['ongoing_reservations'],
            'totalCompletedReservations' => $currentData['completed_reservations'],
            'currentCheckedinReservations' => $currentData['checkin_reservations'],
            'currentCheckedoutReservations' => $currentData['checkout_reservations'],
        ];
    }

    private function fetchData($startDate, $interval, $dataPoints)
    {
        $new_ongoing_reservations = array_fill(0, $dataPoints, 0);
        $total_completed_reservations = array_fill(0, $dataPoints, 0);
        $check_ins = array_fill(0, $dataPoints, 0);
        $checkout_outs = array_fill(0, $dataPoints, 0);

        for ($i = 0; $i < $dataPoints; $i++) {
            $startOfInterval = $startDate->copy()->add($i, $interval);
            $endOfInterval = $startOfInterval->copy()->endOf($interval);

            $room_reservation = RoomReservation::whereHas('room')->where('hotel_id', User::getAuthenticatedUser()->hotel->id)->get();

            $new_ongoing_reservations[$i] = $room_reservation->whereNotNull('checked_in_at')->whereNull('checked_out_at')
                ->whereBetween('checked_in_at', [$startOfInterval, $endOfInterval])
                ->count();

            $total_completed_reservations[$i] = $room_reservation->whereNotNull('checked_out_at')
                ->whereBetween('checked_out_at', [$startOfInterval, $endOfInterval])
                ->count();

            $check_ins[$i] = $room_reservation->whereNotNull('checked_in_at')
                ->whereBetween('checked_in_at', [$startOfInterval, $endOfInterval])
                ->count();

            $checkout_outs[$i] = $room_reservation->whereNotNull('checked_out_at')
                ->whereBetween('checked_out_at', [$startOfInterval, $endOfInterval])
                ->count();
        }
        return [
            'ongoing_reservations' => $new_ongoing_reservations,
            'completed_reservations' => $total_completed_reservations,
            'checkin_reservations' => $check_ins,
            'checkout_reservations' => $checkout_outs,
        ];
    }

    public function countAvailableRoomsToday()
    {
        $expect_available_rooms = 50;
        $hotel = User::getAuthenticatedUser()->hotel;
        $room_reservations = RoomReservation::where('hotel_id', $hotel->id)->get();
        $available_rooms = Room::with('roomType')
            ->where('hotel_id', $hotel->id)
            ->whereDoesntHave('reservations', function ($query) use ($room_reservations) {
                foreach ($room_reservations as $reservation) {
                    $checkin_date = Carbon::parse($reservation->checkin_date)->format('Y-m-d');
                    $checkout_date = Carbon::parse($reservation->checkout_date)->format('Y-m-d');

                    $query->whereNull('checked_out_at')->orWhere(function ($subQuery) use ($checkin_date, $checkout_date) {
                        $subQuery->where('checkin_date', '<', $checkin_date)
                            ->where('checkout_date', '>', $checkout_date);
                    });
                }
            })
            ->count();
        $status_bar = ($available_rooms / $expect_available_rooms) * 100;

        return [
            'available_rooms' =>  $available_rooms,
            'status_bar' => $status_bar,
        ];
    }

    public function countOccupiedRoomsToday()
    {
        $expected_Occupied_rooms = 50;
        $hotel = User::getAuthenticatedUser()->hotel;
        $room_reservations = RoomReservation::where('hotel_id', $hotel->id)->get();
        $occupied_rooms = Room::with('roomType')
            ->where('hotel_id', $hotel->id)
            ->whereHas('reservations', function ($query) use ($room_reservations) {
                foreach ($room_reservations as $reservation) {
                    $checkin_date = Carbon::parse($reservation->checkin_date)->format('Y-m-d');
                    $checkout_date = Carbon::parse($reservation->checkout_date)->format('Y-m-d');

                    $query->whereNotNull('checked_out_at')->orWhere(function ($subQuery) use ($checkin_date, $checkout_date) {
                        $subQuery->where('checkin_date', '<', $checkin_date)
                            ->where('checkout_date', '>', $checkout_date);
                    });
                }
            })->count();
        $status_bar = ($occupied_rooms / $expected_Occupied_rooms) * 100;
        return [
            'occupiedRooms' => $occupied_rooms,
            'statusBar' => $status_bar,
        ];
    }

    public function calculateTotalTransaction()
    {
        $hotel = User::getAuthenticatedUser()->hotel;
        $payments = Payment::where('user_id', $hotel->id)->pluck('id');
        $transactions = Transaction::whereIn('payment_id',  $payments)->sum('amount');
        return $transactions;
    }

    public function recentBookingSchedule()
    {
        $recent_room_reservation = $this->room_reservation->where('hotel_id', User::getAuthenticatedUser()->hotel->id)
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->latest('created_at')->limit(4)->get();
        return $recent_room_reservation;
    }
}
