<?php

namespace App\Services\Dashboard\Hotel\Store;

use App\Models\HotelSoftware\Expense;
use App\Models\HotelSoftware\StoreInventory;
use App\Models\HotelSoftware\StoreItem;
use App\Models\User;
use Carbon\Carbon;

class StoreStatsService
{

    public function stats(array $data = [])
    {
        $period = $data["period"] ?? 'day';

        if (!in_array($period, ['day', 'week', 'month', 'year'])) {
            $period = 'month';
        }

        $store_data = $this->getDashboardData($period);
        $data = [
            "cards" => [
                [
                    // "icon" => "home",
                    "title" => "Total Store Items",
                    "value" => number_format(array_sum($store_data['totalStoreItems'])),
                    "class" => "primary",
                    'period' =>  $period,
                ],
                [
                    // "icon" => "home",
                    "title" => "Total Store Items Amount",
                    "value" => number_format(array_sum($store_data['totalStoreItemAmount']), 2),
                    "class" => "primary",
                    'period' =>  $period,
                ],
                [
                    // "icon" => "receipt",
                    "title" => "Total Incoming Store Items",
                    "value" => number_format(array_sum($store_data['totalIncomingStoreItems'])),
                    "class" => "primary",
                    'period' =>  $period,
                ],
                [
                    // "icon" => "home",
                    "title" => "Total OutComing Store Items",
                    "value" => number_format(array_sum($store_data['totalOutComingStoreItems'])),
                    "class" => "primary",
                    'period' =>  $period,
                ],

            ],

            "dashboard_data" => $store_data,
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
            'totalStoreItems' => $currentData['totalStoreItems'],
            'totalStoreItemAmount' => $currentData['totalStoreItemAmount'],
            'totalIncomingStoreItems' => $currentData['totalIncomingStoreItems'],
            'totalOutComingStoreItems' => $currentData['totalOutComingStoreItems'],
        ];
    }

    private function fetchData($startDate, $interval, $dataPoints)
    {
        $total_store_items = array_fill(0, $dataPoints, 0);
        $total_store_items_amount = array_fill(0, $dataPoints, 0);
        $total_incoming_store_items = array_fill(0, $dataPoints, 0);
        $total_outgoing_store_items = array_fill(0, $dataPoints, 0);

        for ($i = 0; $i < $dataPoints; $i++) {
            $startOfInterval = $startDate->copy()->add($i, $interval);
            $endOfInterval = $startOfInterval->copy()->endOf($interval);
            $store_items = StoreItem::whereHas('store', function ($query) {
                $query->where('hotel_id', User::getAuthenticatedUser()->hotel->id);
            })->whereBetween('created_at', [$startOfInterval, $endOfInterval])
            ->get();
            $total_store_items[$i] =  $store_items->count();
            $total_store_items_amount[$i] =  $store_items->sum('cost_price');
            $total_incoming_store_items[$i] = StoreInventory::whereHas('store', function ($query) {
                $query->where('hotel_id', User::getAuthenticatedUser()->hotel->id);
            })->incomingInventory()->whereBetween('created_at', [$startOfInterval, $endOfInterval])
            ->count();
            $total_outgoing_store_items[$i] = StoreInventory::whereHas('store', function ($query) {
                $query->where('hotel_id', User::getAuthenticatedUser()->hotel->id);
            })->outgoingInventory()->whereBetween('created_at', [$startOfInterval, $endOfInterval])
            ->count();
            
        }
        return [
            'totalStoreItems' => $total_store_items,
            'totalStoreItemAmount' => $total_store_items_amount,
            'totalIncomingStoreItems' => $total_incoming_store_items,
            'totalOutComingStoreItems' =>  $total_outgoing_store_items,
        ];
    }
}
