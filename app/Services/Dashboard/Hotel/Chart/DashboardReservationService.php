<?php

namespace App\Services\Dashboard\Hotel\Chart;

use App\Constants\StatusConstants;
use App\Models\HotelSoftware\RoomReservation;
use App\Models\Payment;
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
            "dashboard_data" => $room_reservation_data,
        ];

        return $data;
    }

    public function getData($period)
    {   
        // Adjust the start date based on the selected period
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

        $currentData = $this->fetchData($currentStartDate, $interval, $dataPoints);
        $previousData = $this->fetchData($previousStartDate, $interval, $dataPoints);

        // Calculate percentage changes
        $room_reservation_checkin_percentage = $this->calculatePercentageChange($currentData['checkedin_count'], $previousData['checkedin_count']);
        $room_reservation_checkout_percentage = $this->calculatePercentageChange($currentData['checkedout_count'], $previousData['checkedout_count']);

        return [
            'reservation_count' => $currentData['reservation_data'],
            'room_reservation_revenue' => $currentData['room_reservation_revenue'],
            'room_reservation_checkin_percentage' => $room_reservation_checkin_percentage,
            'room_reservation_checkout_percentage' =>  $room_reservation_checkout_percentage,
            'data_labels' => $labels,
            'checkedins_count' => array_sum($currentData['checkedin_count']),
            'checkedouts_count' => array_sum($currentData['checkedout_count']),
            'checked_ins' => $currentData['checkedin_count'],
            'checked_outs' => $currentData['checkedout_count'],

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

            // Fetch the room reservation data for each interval 
            $room_reservation_checked_in[$i] = RoomReservation::whereNotNull('checked_in_at')
                ->whereBetween('checked_in_at', [$startOfInterval, $endOfInterval])
                ->count();
            $room_reservation_checked_out[$i] = RoomReservation::whereNotNull('checked_out_at')
                ->whereBetween('checked_out_at', [$startOfInterval, $endOfInterval])
                ->count();
            $room_reservation_count[$i] = RoomReservation::all()
                ->whereBetween('created_at', [$startOfInterval, $endOfInterval])
                ->count();

            $room_reservation_revenue[$i] = Payment::where('status', strtolower(StatusConstants::COMPLETED))
                ->where('payable_type', 'App\Models\HotelSoftware\RoomReservation')
                ->whereBetween('created_at', [$startOfInterval, $endOfInterval])
                ->sum('amount');
            // $labels[] = $startOfInterval->format($interval === 'hour' ? 'H:i' : 'd M');
        }

        return [
            'reservation_data' => $room_reservation_count,
            'room_reservation_revenue' => $room_reservation_revenue,
            // 'data_labels' => $labels,
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
