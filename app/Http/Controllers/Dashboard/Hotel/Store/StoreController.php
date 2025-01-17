<?php

namespace App\Http\Controllers\Dashboard\Hotel\Store;

use App\Http\Controllers\Controller;
use App\Models\HotelSoftware\StoreItem;
use App\Models\User;
use App\Services\Dashboard\Hotel\Chart\DashboardStoreService;
use App\Services\Dashboard\Hotel\Store\StoreStatsService;
use Illuminate\Http\Request;

class StoreController extends Controller
{

    protected $store_stat_service;
    protected $store_item_chart_service;
    public function __construct()
    {
        $this->store_stat_service = new StoreStatsService();
        $this->store_item_chart_service = new DashboardStoreService();
    }
    public function overview(Request $request)
    {
        $period = $request->get('period', 'day');
        $chart_period = $request->get('chart_period', 'day');
        if (!in_array($period, ['day', 'week', 'month', 'year'])) {
            $period = 'day';
        }
        if (!in_array($chart_period, ['day', 'week', 'month', 'year'])) {
            $chart_period = 'day';
        }
        $user = User::getAuthenticatedUser();
        $top_store_items = StoreItem::whereHas('store', function ($query) use ($user) {
            $query->where('hotel_id', $user->hotel->id);
        })->orderBy('cost_price', 'desc')->limit(5)->get();
        return view('dashboard.hotel.store.dashboard', [
            'store_item_stats' => $this->store_stat_service->stats(['period' => $period]),
            'store_item_chart_data' => $this->store_item_chart_service->chartStats(['chart_period' => $chart_period]),
            'top_store_items' => $top_store_items,
        ]);
    }
}
