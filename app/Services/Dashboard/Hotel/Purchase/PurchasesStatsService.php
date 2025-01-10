<?php

namespace App\Services\Dashboard\Hotel\Purchase;

use App\Models\HotelSoftware\Purchase;
use App\Models\User;
use Carbon\Carbon;

class PurchasesStatsService
{

    public function stats(array $data = [])
    {
        $period = $data["period"] ?? 'day';

        if (!in_array($period, ['day', 'week', 'month', 'year'])) {
            $period = 'month';
        }

        $purchase_data = $this->getDashboardData($period);

        $data = [
            "cards" => [
                [
                    // "icon" => "home",
                    "title" => "Total Purchases",
                    "value" => number_format(array_sum($purchase_data['totalPurchases'])),
                    "class" => "primary",
                    'period' =>  $period,
                ],
                [
                    // "icon" => "home",
                    "title" => "Total Purchases Amount",
                    "value" => number_format(array_sum($purchase_data['totalPurchasesAmount']), 2),
                    "class" => "primary",
                    'period' =>  $period,
                ],
                [
                    // "icon" => "receipt",
                    "title" => "Total Paid Purchases",
                    "value" => number_format(array_sum($purchase_data['totalPaidPurchases'])),
                    "class" => "primary",
                    'period' =>  $period,
                ],
                [
                    // "icon" => "home",
                    "title" => "Total Unpaid Purchases",
                    "value" => number_format(array_sum($purchase_data['totalUnpaidPurchases'])),
                    "class" => "primary",
                    'period' =>  $period,
                ],

            ],

            "dashboard_data" => $purchase_data,
        ];

        return $data;
    }

    public function getDashboardData($period = 'month',)
    {
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
        $currentData = $this->fetchData($currentStartDate, $interval, $dataPoints);
        $previousData = $this->fetchData($previousStartDate, $interval, $dataPoints);
        return [
            'totalPurchases' => $currentData['totalPurchases'],
            'totalPurchasesAmount' => $currentData['totalPurchasesAmount'],
            'totalPaidPurchases' => $currentData['totalPaidPurchases'],
            'totalUnpaidPurchases' => $currentData['totalUnpaidPurchases'],
        ];
    }

    private function fetchData($startDate, $interval, $dataPoints)
    {
        $total_purchases = array_fill(0, $dataPoints, 0);
        $total_purchases_amount = array_fill(0, $dataPoints, 0);
        $total_paid_purchases = array_fill(0, $dataPoints, 0);
        $total_unpaid_purchases = array_fill(0, $dataPoints, 0);

        for ($i = 0; $i < $dataPoints; $i++) {
            $startOfInterval = $startDate->copy()->add($i, $interval);
            $endOfInterval = $startOfInterval->copy()->endOf($interval);
            $purchases = Purchase::whereHas('store', function ($store) {
                $store->where('store_id', User::getAuthenticatedUser()->hotel->id);
            })->whereBetween('created_at', [$startOfInterval, $endOfInterval])
                ->get();
            $total_purchases[$i] = $purchases->count();
            $total_purchases_amount[$i] = $purchases->sum('amount');
            $total_paid_purchases[$i] = $purchases->sum(function ($expense) {
                return $expense->payments->sum('amount');
            });
            $total_unpaid_purchases[$i] =  $total_purchases_amount[$i] - $total_paid_purchases[$i];
        }
        return [
            'totalPurchases' => $total_purchases,
            'totalPurchasesAmount' => $total_purchases_amount,
            'totalPaidPurchases' => $total_paid_purchases,
            'totalUnpaidPurchases' => $total_unpaid_purchases,
        ];
    }
}
