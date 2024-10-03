<?php

use App\Models\HotelSoftware\Guest;
use App\Models\HotelSoftware\ItemCategory;
use App\Models\HotelSoftware\Outlet;
use App\Models\HotelSoftware\Room;
use App\Models\User;
use Illuminate\Support\Facades\DB;

function getModelItems($model)
{
    $model_list = null;

    if ($model == 'countries') {
        $model_list = DB::table('countries')->select('id', 'name')->orderBy('name', 'asc')->get();
    } elseif ($model == 'states') {
        $model_list = DB::table('states')->select('id', 'name')->orderBy('name', 'asc')->get();
    } elseif ($model == 'rooms') {
        $model_list  = Room::where('hotel_id', User::getAuthenticatedUser()->hotel->id)->get();
    } elseif ($model == 'guests') {
        $model_list  = Guest::where('hotel_id', User::getAuthenticatedUser()->hotel->id)->get();
    }
    if ($model == 'restaurant-outlets') {
        $model_list = Outlet::where('hotel_id', User::getAuthenticatedUser()->hotel->id)->where('type', 'restaurant')->get();
    }
    if ($model == 'item-categories') {
        $model_list = ItemCategory::all();
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
