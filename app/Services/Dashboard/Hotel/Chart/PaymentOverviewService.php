<?php

namespace App\Services\Dashboard\Hotel\Chart;

use App\Constants\StatusConstants;
use App\Models\Payment;
use App\Models\User;
use Carbon\Carbon;

class PaymentOverviewService
{
    public function stats(array $data = [])
    {
        $period = $data["period"] ?? 'month';
        if (!in_array($period, ['day', 'week', 'month', 'year'])) {
            $period = 'month';
        }

        $payment_data = $this->getAnalyticData($period);
        // dd($payment_data);
        return [
            'cards' => $this->getCards($payment_data, $period),
            'data' => $payment_data,
        ];
    }

    public function getAnalyticData($period)
    {
        switch ($period) {
            case 'year':
                $currentStartDate = Carbon::now()->startOfYear();
                $previousStartDate = Carbon::now()->subYear()->startOfYear();
                $interval = 'month';
                $labels = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
                $dataPoints = 12;
                break;
            case 'month':
                $currentStartDate = Carbon::now()->startOfMonth();
                $previousStartDate = Carbon::now()->subMonth()->startOfMonth();
                $interval = 'day';
                $labels = range(1, Carbon::now()->daysInMonth);
                $dataPoints = Carbon::now()->daysInMonth;
                break;
            case 'day':
                $currentStartDate = Carbon::now()->startOfDay();
                $previousStartDate = Carbon::now()->subDay()->startOfDay();
                $interval = 'hour';
                $labels = [];
                for ($i = 0; $i < 24; $i++) {
                    $hour = $i % 12 == 0 ? 12 : $i % 12;
                    $suffix = $i < 12 ? 'AM' : 'PM';
                    $labels[] = $hour . ':00 ' . $suffix;
                }
                $dataPoints = 24;
                break;
            case 'week':
            default:
                $currentStartDate = Carbon::now()->startOfWeek();
                $previousStartDate = Carbon::now()->subWeek()->startOfWeek();
                $interval = 'day';
                $labels = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
                $dataPoints = 7;
                break;
        }

        $currentData = $this->fetchData($currentStartDate, $interval, $dataPoints);
        $previousData = $this->fetchData($previousStartDate, $interval, $dataPoints);

        $completedChange = $this->calculatePercentageChange($currentData['completed'], $previousData['completed']);
        $pendingChange = $this->calculatePercentageChange($currentData['pending'], $previousData['pending']);

        return [
            'labels' => $labels,

            // ✅ Group status data
            'status_data' => [
                'total' => $currentData['total'],
                'completed' => $currentData['completed'],
                'pending' => $currentData['pending'],
                'failed' => $currentData['failed'],
                'refunded' => $currentData['refunded'],
                'revenue' => $currentData['revenue'],
                'total_amount' => array_sum($currentData['revenue']),
                'completed_percentage_change' => $completedChange,
                'pending_percentage_change' => $pendingChange,
            ],

            // ✅ Group distribution data
            'distribution_data' => [
                'bar_orders' => $currentData['bar_orders'],
                'restaurant_orders' => $currentData['restaurant_orders'],
                'guest_payments' => $currentData['guest_payments'],
                'room_reservations' => $currentData['room_reservations'],
            ],
        ];
    }


    private function fetchData($startDate, $interval, $dataPoints)
    {
        $hotelUserId = User::getAuthenticatedUser()->hotel->user_id;

        $total = array_fill(0, $dataPoints, 0);
        $completed = array_fill(0, $dataPoints, 0);
        $pending = array_fill(0, $dataPoints, 0);
        $failed = array_fill(0, $dataPoints, 0);
        $refunded = array_fill(0, $dataPoints, 0);
        $revenue = array_fill(0, $dataPoints, 0);

        $barOrders = array_fill(0, $dataPoints, 0);
        $restaurantOrders = array_fill(0, $dataPoints, 0);
        $guestPayments = array_fill(0, $dataPoints, 0);
        $roomReservations = array_fill(0, $dataPoints, 0);

        for ($i = 0; $i < $dataPoints; $i++) {
            $startOfInterval = $startDate->copy()->add($i, $interval);
            $endOfInterval = $startOfInterval->copy()->endOf($interval);

            // Get total payments in this interval
            $periodPayments = Payment::where('user_id', $hotelUserId)->get();

            // Count by status
            $total[$i] = $periodPayments->whereBetween('created_at', [$startOfInterval, $endOfInterval])->count();;
            $completed[$i] = $periodPayments->whereBetween('created_at', [$startOfInterval, $endOfInterval])->where('status', strtolower(StatusConstants::COMPLETED))->count();
            $pending[$i] = $periodPayments->whereBetween('created_at', [$startOfInterval, $endOfInterval])->where('status', 'pending')->count();
            $failed[$i] = $periodPayments->whereBetween('created_at', [$startOfInterval, $endOfInterval])->where('status', 'failed')->count();
            $refunded[$i] = $periodPayments->whereBetween('created_at', [$startOfInterval, $endOfInterval])->where('status', 'refunded')->count();

            // Revenue sum
            $revenue[$i] = $periodPayments->whereBetween('created_at', [$startOfInterval, $endOfInterval])->sum('amount');

            // Distribution by payable type
            $barOrders[$i] = $periodPayments->whereBetween('created_at', [$startOfInterval, $endOfInterval])->where('payable_type', \App\Models\HotelSoftware\BarOrder::class)->sum('amount');
            $restaurantOrders[$i] = $periodPayments->whereBetween('created_at', [$startOfInterval, $endOfInterval])->where('payable_type', \App\Models\HotelSoftware\RestaurantOrder::class)->sum('amount');
            $guestPayments[$i] = $periodPayments->whereBetween('created_at', [$startOfInterval, $endOfInterval])->where('payable_type', \App\Models\HotelSoftware\Guest::class)->sum('amount');
            $roomReservations[$i] = $periodPayments->whereBetween('created_at', [$startOfInterval, $endOfInterval])->where('payable_type', \App\Models\HotelSoftware\RoomReservation::class)->sum('amount');
        }

        return [
            'total' => $total,
            'completed' => $completed,
            'pending' => $pending,
            'failed' => $failed,
            'refunded' => $refunded,
            'revenue' => $revenue,
            'bar_orders' => $barOrders,
            'restaurant_orders' => $restaurantOrders,
            'guest_payments' => $guestPayments,
            'room_reservations' => $roomReservations,
        ];
    }


    private function calculatePercentageChange($current, $previous)
    {
        $currentTotal = array_sum($current);
        $previousTotal = array_sum($previous);

        if ($previousTotal == 0) {
            return $currentTotal > 0 ? 100 : 0;
        }

        return round((($currentTotal - $previousTotal) / $previousTotal) * 100, 2);
    }

    private function getCards($data, $period)
    {
        $status = $data['status_data'] ?? [];

        return [
            [
                "title" => "Total Payments",
                "value" => array_sum($status['total'] ?? []),
                "class" => "primary",
                "period" => $period,
            ],
            [
                "title" => "Total Amount",
                "value" => currencySymbol().number_format($status['total_amount'] ?? 0, 2),
                "class" => "primary",
                "period" => $period,
            ],
            [
                "title" => "Completed Payments",
                "value" => array_sum($status['completed'] ?? []),
                "class" => "success",
                "period" => $period,
            ],
            [
                "title" => "Pending Payments",
                "value" => array_sum($status['pending'] ?? []),
                "class" => "warning",
                "period" => $period,
            ],
        ];
    }
}
