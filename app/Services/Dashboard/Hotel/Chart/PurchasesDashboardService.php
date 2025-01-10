<?php

namespace App\Services\Dashboard\Hotel\Chart;

use App\Models\HotelSoftware\Purchase;
use App\Models\User;
use Carbon\Carbon;

class PurchasesDashboardService
{

    public function chartStats(array $data = [])
    {
        $period = $data["chart_period"] ?? 'day';

        if (!in_array($period, ['day', 'week', 'month', 'year'])) {
            $period = 'day';
        }

        $purchases_chart_data = $this->getData($period);

        $data = [
            "chart_data" => $purchases_chart_data,
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
                    $period = $i < 12 ? 'AM' : 'PM';
                    $labels[] = $hour . ':00 ' . $period;
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
                    $period = $i < 12 ? 'AM' : 'PM';
                    $labels[] = $hour . ':00 ' . $period;
                }
                $dataPoints = 24;
                break;
        }

        $currentData = $this->fetchData($currentStartDate, $interval, $dataPoints);
        $previousData = $this->fetchData($previousStartDate, $interval, $dataPoints);
        return [
            'data_labels' => $labels,
            'total_purchases_amount' => $currentData['total_purchases_amount'],
            'total_paid_purchases_amount' => $currentData['total_paid_purchases_amount'],
            'total_unpaid_purchases_amount' => $currentData['total_unpaid_purchases_amount'],
        ];
    }

    private function fetchData($startDate, $interval, $dataPoints)
    {
        $total_purchases_amount = array_fill(0, $dataPoints, 0);
        $total_paid_purchases_amount = array_fill(0, $dataPoints, 0);
        $total_unpaid_purchases_amount = array_fill(0, $dataPoints, 0);

        for ($i = 0; $i < $dataPoints; $i++) {
            $startOfInterval = $startDate->copy()->add($i, $interval);
            $endOfInterval = $startOfInterval->copy()->endOf($interval);
            $purchases = Purchase::whereHas('store', function ($store) {
                $store->where('store_id', User::getAuthenticatedUser()->hotel->id);
            })->whereBetween('created_at', [$startOfInterval, $endOfInterval])
                ->get();

            $total_purchases_amount[$i] = $purchases->sum('amount');
            $total_paid_purchases_amount[$i] = $purchases->sum(function ($expense) {
                return $expense->payments->sum('amount');
            });
            $total_unpaid_purchases_amount[$i] = $total_purchases_amount[$i] - $total_paid_purchases_amount[$i];
        }
        return [
            'total_purchases_amount' => $total_purchases_amount,
            'total_paid_purchases_amount' => $total_paid_purchases_amount,
            'total_unpaid_purchases_amount' => $total_unpaid_purchases_amount,
        ];
    }
}
