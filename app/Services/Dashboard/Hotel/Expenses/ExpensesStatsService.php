<?php

namespace App\Services\Dashboard\Hotel\Expenses;

use App\Models\HotelSoftware\Expense;
use App\Models\User;
use Carbon\Carbon;

class ExpensesStatsService
{

    public function stats(array $data = [])
    {
        $period = $data["period"] ?? 'day';

        if (!in_array($period, ['day', 'week', 'month', 'year'])) {
            $period = 'month';
        }

        $expenses_data = $this->getDashboardData($period);

        $data = [
            "cards" => [
                [
                    // "icon" => "home",
                    "title" => "Total Expenses",
                    "value" => number_format(array_sum($expenses_data['totalExpenses'])),
                    "class" => "primary",
                    'period' =>  $period,
                ],
                [
                    // "icon" => "home",
                    "title" => "Total Expenses Amount",
                    "value" => number_format(array_sum($expenses_data['totalExpensesAmount']), 2),
                    "class" => "primary",
                    'period' =>  $period,
                ],
                [
                    // "icon" => "receipt",
                    "title" => "Total Paid Expenses",
                    "value" => number_format(array_sum($expenses_data['totalPaidExpenses'])),
                    "class" => "primary",
                    'period' =>  $period,
                ],
                [
                    // "icon" => "home",
                    "title" => "Total Unpaid Expenses",
                    "value" => number_format(array_sum($expenses_data['totalUnpaidExpenses'])),
                    "class" => "primary",
                    'period' =>  $period,
                ],

            ],

            "dashboard_data" => $expenses_data,
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
            'totalExpenses' => $currentData['totalExpenses'],
            'totalExpensesAmount' => $currentData['totalExpensesAmount'],
            'totalPaidExpenses' => $currentData['totalPaidExpenses'],
            'totalUnpaidExpenses' => $currentData['totalUnpaidExpenses'],
        ];
    }

    private function fetchData($startDate, $interval, $dataPoints)
    {
        $total_expenses = array_fill(0, $dataPoints, 0);
        $total_expenses_amount = array_fill(0, $dataPoints, 0);
        $total_paid_expenses = array_fill(0, $dataPoints, 0);
        $total_unpaid_expenses = array_fill(0, $dataPoints, 0);

        for ($i = 0; $i < $dataPoints; $i++) {
            $startOfInterval = $startDate->copy()->add($i, $interval);
            $endOfInterval = $startOfInterval->copy()->endOf($interval);
            $expenses = Expense::where('hotel_id', User::getAuthenticatedUser()->hotel->id)
                ->whereBetween('created_at', [$startOfInterval, $endOfInterval])
                ->get();
            $total_expenses[$i] = $expenses->count();
            $total_expenses_amount[$i] = $expenses->sum('amount');
            $total_paid_expenses[$i] = $expenses->sum(function ($expense) {
                return $expense->payments->sum('amount');
            });
            $total_unpaid_expenses[$i] =    $total_expenses_amount[$i] - $total_paid_expenses[$i];
        }
        return [
            'totalExpenses' => $total_expenses_amount,
            'totalExpensesAmount' => $total_expenses_amount,
            'totalPaidExpenses' => $total_paid_expenses,
            'totalUnpaidExpenses' => $total_unpaid_expenses,
        ];
    }
}
