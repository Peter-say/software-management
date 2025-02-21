<?php

namespace App\Services\Dashboard\Hotel\Chart;

use App\Constants\StatusConstants;
use App\Models\HotelSoftware\RoomReservation;
use App\Models\Payment;
use App\Models\User;
use Carbon\Carbon;

class DashboardReservationService
{

    public function stats(array $data = [])
    {
        $period = $data["booking_period"] ?? 'week';
        if (!in_array($period, ['week', 'year'])) {
            $period = 'week';
        }
        $room_reservation_data = $this->getData($period);
        $data = [
            "data" => $room_reservation_data,
        ];

        return $data;
    }

    public function analytics(array $data = [])
    {
        $analytic_period = $data["analytic_period"] ?? 'month';

        if (!in_array($analytic_period, ['day', 'week', 'month', 'year'])) {
            $analytic_period = 'month';
        }
        $reservation_analytic_data = $this->getAnalyticData($analytic_period);

        $data = [
            'data' => $reservation_analytic_data,
        ];

        return $data;
    }

    public function getData($period)
    {
        // Adjust the start date based on the selected period
        if ($period) {
            switch ($period) {
                case 'year':
                    $currentStartDate = Carbon::now()->startOfYear();
                    $previousStartDate = Carbon::now()->subYear()->startOfYear();
                    $interval = 'month'; // Monthly intervals for the year
                    $labels = ["Ja", "Fe", "Mr", "Ap", "My", "Jn", "Jl", "Au", "Sp", "Oc", "Nv", "Dc"];
                    $dataPoints = 12;
                    break;
                case 'week':
                    $currentStartDate = Carbon::now()->startOfWeek();
                    $previousStartDate = Carbon::now()->subWeek()->startOfWeek();
                    $interval = 'day'; // Daily intervals for the week
                    $labels = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
                    $dataPoints = 7;
                    break;
                default: // Default to daily
                    $currentStartDate = Carbon::now()->startOfWeek();
                    $previousStartDate = Carbon::now()->subWeek()->startOfWeek();
                    $interval = 'day'; // Daily intervals for the week
                    $labels = ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"];
                    $dataPoints = 7;
                    break;
            }
        }

        $currentData = $this->fetchData($currentStartDate, $interval, $dataPoints);
        $previousData = $this->fetchData($previousStartDate, $interval, $dataPoints);

        // Calculate percentage changes
        $room_reservation_checkin_percentage = $this->calculatePercentageChange($currentData['checkedin_count'], $previousData['checkedin_count']);
        $room_reservation_checkout_percentage = $this->calculatePercentageChange($currentData['checkedout_count'], $previousData['checkedout_count']);

        return [
            'reservation_count' => $currentData['room_reservation_count'],
            'room_reservation_checkin_percentage' => $room_reservation_checkin_percentage,
            'room_reservation_checkout_percentage' =>  $room_reservation_checkout_percentage,
            'data_labels' => $labels,
            'checkedins_count' => array_sum($currentData['checkedin_count']),
            'checkedouts_count' => array_sum($currentData['checkedout_count']),
            'checked_ins' => $currentData['checkedin_count'],
            'checked_outs' => $currentData['checkedout_count'],

        ];
    }
    public function getAnalyticData($analytic_period)
    {

        if ($analytic_period) {
            switch ($analytic_period) {
                case 'year':
                    $currentStartDate = Carbon::now()->startOfYear();
                    $previousStartDate = Carbon::now()->subYear()->startOfYear();
                    $interval = 'month'; // Monthly intervals for the year
                    $labels = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
                    $dataPoints = 12;
                    break;
                case 'month':
                    $currentStartDate = Carbon::now()->startOfMonth();
                    $previousStartDate = Carbon::now()->subMonth()->startOfMonth();
                    $interval = 'day'; // Daily intervals for the month
                    $labels = [];
                    for ($i = 1; $i <= Carbon::now()->daysInMonth; $i++) {
                        $labels[] = $i;
                    }
                    $dataPoints = Carbon::now()->daysInMonth;
                    break;
                case 'week':
                    $currentStartDate = Carbon::now()->startOfWeek();
                    $previousStartDate = Carbon::now()->subWeek()->startOfWeek();
                    $interval = 'day'; // Daily intervals for the week
                    $labels = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
                    $dataPoints = 7;
                    break;
                case 'day':
                    $currentStartDate = Carbon::now()->startOfDay();
                    $previousStartDate = Carbon::now()->subDay()->startOfDay();
                    $interval = 'hour'; // Hourly intervals for the day
                    $labels = [];
                    for ($i = 0; $i < 24; $i++) {
                        $hour = $i % 12 == 0 ? 12 : $i % 12;
                        $analytic_period = $i < 12 ? 'AM' : 'PM';
                        $labels[] = $hour . ':00 ' . $analytic_period;
                    }
                    $dataPoints = 24;
                    break;
                default: // Default to daily
                    $currentStartDate = Carbon::now()->startOfDay();
                    $previousStartDate = Carbon::now()->subDay()->startOfDay();
                    $interval = 'hour'; // Hourly intervals for the day
                    $labels = [];
                    for ($i = 0; $i < 24; $i++) {
                        $hour = $i % 12 == 0 ? 12 : $i % 12;
                        $analytic_period = $i < 12 ? 'AM' : 'PM';
                        $labels[] = $hour . ':00 ' . $analytic_period;
                    }
                    $dataPoints = 24;
                    break;
            }
        }

        $currentData = $this->fetchData($currentStartDate, $interval, $dataPoints);
        $previousData = $this->fetchData($previousStartDate, $interval, $dataPoints);

        // Calculate percentage changes
        $room_reservation_checkin_percentage = $this->calculatePercentageChange($currentData['checkedin_count'], $previousData['checkedin_count']);
        $room_reservation_checkout_percentage = $this->calculatePercentageChange($currentData['checkedout_count'], $previousData['checkedout_count']);

        return [
            'reservation_count' => $currentData['room_reservation_count'],
            'room_reservation_revenue' => $currentData['room_reservation_revenue'],
            'room_reservation_checkin_percentage' => $room_reservation_checkin_percentage,
            'room_reservation_checkout_percentage' =>  $room_reservation_checkout_percentage,
            'data_labels' => $labels,
        ];
    }


    private function fetchData($startDate, $interval, $dataPoints)
    {
        $room_reservation_count = array_fill(0, $dataPoints, 0);
        $room_reservation_revenue = array_fill(0, $dataPoints, 0); // Initialize data array with 0
        $room_reservation_checked_in = array_fill(0, $dataPoints, 0);
        $room_reservation_checked_out = array_fill(0, $dataPoints, 0);

        for ($i = 0; $i < $dataPoints; $i++) {
            $startOfInterval = $startDate->copy()->add($i, $interval);
            $endOfInterval = $startOfInterval->copy()->endOf($interval);

            $room_reservation = RoomReservation::whereHas('room')->where('hotel_id', User::getAuthenticatedUser()->hotel->id)->get();

            $room_reservation_checked_in[$i] = $room_reservation->whereNotNull('checked_in_at')
                ->whereBetween('checked_in_at', [$startOfInterval, $endOfInterval])
                ->count();
            $room_reservation_checked_out[$i] = $room_reservation->whereNotNull('checked_out_at')
                ->whereBetween('checked_out_at', [$startOfInterval, $endOfInterval])
                ->count();
            $room_reservation_count[$i] = $room_reservation->whereBetween('created_at', [$startOfInterval, $endOfInterval])
                ->count();

            $room_reservation_revenue[$i] = Payment::where('status', strtolower(StatusConstants::COMPLETED))
                ->where('payable_type', 'App\Models\HotelSoftware\RoomReservation')
                ->whereBetween('created_at', [$startOfInterval, $endOfInterval])
                ->sum('amount');
            // $labels[] = $startOfInterval->format($interval === 'hour' ? 'H:i' : 'd M');
        }

        return [
            'room_reservation_count' => $room_reservation_count,
            'room_reservation_revenue' => $room_reservation_revenue,
            'checkedin_count' => $room_reservation_checked_in,
            'checkedout_count' => $room_reservation_checked_out,
        ];
    }

    private function calculatePercentageChange($currentData, $previousData)
    {
        $currentTotal = array_sum($currentData);
        $previousTotal = array_sum($previousData);

        if ($previousTotal == 0) {
            return $currentTotal > 0 ? 100 : 0;
        }

        return round((($currentTotal - $previousTotal) / $previousTotal) * 100, 2);
    }
}
