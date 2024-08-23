<?php

use App\Models\HotelSoftware\Guest;
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
    }elseif($model == 'rooms'){
        $model_list  = Room::where('hotel_id', User::getAuthenticatedUser()->hotel->id)->get();
    }elseif($model == 'guests'){
        $model_list  = Guest::where('hotel_id', User::getAuthenticatedUser()->hotel->id)->get();
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
