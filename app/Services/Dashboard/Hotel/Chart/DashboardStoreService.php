<?php

namespace App\Services\Dashboard\Hotel\Chart;

use App\Models\HotelSoftware\Expense;
use App\Models\HotelSoftware\StoreInventory;
use App\Models\User;
use Carbon\Carbon;

class DashboardStoreService
{

    public function chartStats(array $data = [])
    {
        $period = $data["chart_period"] ?? 'day';

        if (!in_array($period, ['day', 'week', 'month', 'year'])) {
            $period = 'day';
        }

        $store_item_chart_data = $this->getData($period);

        $data = [
            "chart_data" => $store_item_chart_data,
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
            'total_incoming_store_items' => $currentData['total_incoming_store_items'],
            'total_outgoing_store_items' => $currentData['total_outgoing_store_items'],
        ];
    }

    private function fetchData($startDate, $interval, $dataPoints)
    {
        $total_incoming_store_items = array_fill(0, $dataPoints, 0);
        $total_outgoing_store_items = array_fill(0, $dataPoints, 0);

        for ($i = 0; $i < $dataPoints; $i++) {
            $startOfInterval = $startDate->copy()->add($i, $interval);
            $endOfInterval = $startOfInterval->copy()->endOf($interval);
            $total_incoming_store_items[$i] = StoreInventory::whereHas('store', function ($query) {
                $query->where('hotel_id', User::getAuthenticatedUser()->hotel->id);
            })->incomingInventory()->whereBetween('created_at', [$startOfInterval, $endOfInterval])
                ->count();
            $total_outgoing_store_items[$i] =  $total_outgoing_store_items[$i] = StoreInventory::whereHas('store', function ($query) {
                $query->where('hotel_id', User::getAuthenticatedUser()->hotel->id);
            })->outgoingInventory()->whereBetween('created_at', [$startOfInterval, $endOfInterval])
                ->count();
        }
        return [
            'total_incoming_store_items' => $total_outgoing_store_items,
            'total_outgoing_store_items' => $total_incoming_store_items,
        ];
    }
}
