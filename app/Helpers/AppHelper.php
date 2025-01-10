<?php

use App\Models\HotelSoftware\ExpenseCategory;
use App\Models\HotelSoftware\ExpenseItem;
use App\Models\HotelSoftware\Guest;
use App\Models\HotelSoftware\ItemCategory;
use App\Models\HotelSoftware\ItemSubCategory;
use App\Models\HotelSoftware\Outlet;
use App\Models\HotelSoftware\Room;
use App\Models\HotelSoftware\StoreItem;
use App\Models\HotelSoftware\Supplier;
use App\Models\HotelSoftware\WalkInCustomer;
use App\Models\User;
use Illuminate\Support\Facades\DB;

function getModelItems($model)
{
    $model_list = null;

    $hotelId = User::getAuthenticatedUser()->hotel->id;

    if ($model == 'countries') {
        $model_list = DB::table('countries')->select('id', 'name')->orderBy('name', 'asc')->get();
    } elseif ($model == 'states') {
        $model_list = DB::table('states')->select('id', 'name')->orderBy('name', 'asc')->get();
    } elseif ($model == 'rooms') {
        $model_list = Room::where('hotel_id', $hotelId)->get();
    } elseif ($model == 'guests') {
        $model_list = Guest::where('hotel_id', $hotelId)->get();
    } elseif ($model == 'restaurant-outlets') {
        $model_list = Outlet::where('hotel_id', $hotelId)->where('type', 'restaurant')->get();
    } elseif ($model == 'suppliers') {
        $model_list = Supplier::where('hotel_id', $hotelId)->get();
    } elseif ($model == 'expense-categories') {
        $model_list = ExpenseCategory::where('hotel_id', $hotelId)->get();
    } elseif ($model == 'expense-items') {
        $model_list = ExpenseItem::where('hotel_id', $hotelId)->get();
    } elseif ($model == 'store-items') {
        $model_list = StoreItem::whereHas('store', function ($query) use ($hotelId) {
            $query->where('hotel_id', $hotelId);
        })->get();
    } elseif ($model == 'walk_in_customers') {
        // Get the outlet (restaurant) for the hotel
        $outlet = Outlet::where('hotel_id', $hotelId)->where('type', 'restaurant')->first();
        // Get all walk-in customers associated with that restaurant outlet
        $model_list = WalkInCustomer::whereHas('restaurantOrders', function ($query) use ($outlet) {
            $query->where('outlet_id', $outlet->id);
        })->get();
    }
    if ($model == 'item-categories') {
        $model_list = ItemCategory::all();
    }
    if ($model == 'item-sub_categories') {
        $model_list = ItemSubCategory::all();
    }
    return $model_list;
}

function getStatusAsString(int $status): string
{
    if ($status === 1) {
        return 'Active';
    } else {
        return 'Inactive';
    }
}
function getItemAvailability(int $status): string
{
    if ($status === 1) {
        return 'Available';
    } else {
        return 'Not Available';
    }
}
function getStatuses($status = null)
{
    $statuses = [
        'pending' => [
            'icon' => 'fas fa-hourglass-start',
            'color' => 'text-warning',
            'label' => 'Pending'
        ],
        'in_progress' => [
            'icon' => 'fas fa-spinner',
            'color' => 'text-info',
            'label' => 'In Progress'
        ],
        'ready' => [
            'icon' => 'fas fa-check',
            'color' => 'text-success',
            'label' => 'Ready'
        ],
    ];

    return $status && isset($statuses[$status]) ? $statuses[$status] : null;
}


function formatNumber($number)
{
    if ($number >= 1000000) {
        return number_format($number / 1000000, 1) . 'M';
    } elseif ($number >= 1000) {
        return number_format($number / 1000, 1) . 'K';
    } else {
        return number_format($number);
    }
}

if (!function_exists('getStorageUrl')) {
    function getStorageUrl($relativePath)
    {
        if (app()->environment('local')) {
            return url($relativePath);
        } else {
            return url("public/{$relativePath}");
        }
    }
}
