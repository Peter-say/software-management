<?php

namespace App\Services\Dashboard\Developer;

use App\Models\HotelSoftware\Hotel;
use App\Models\User;

class AppStatsServices
{
    public function appStats()
    {
        $hotels = new Hotel();
        $total_hotels = $hotels->count();
        $active_hotels = $hotels->where('status', strtolower('active'))->count();
        $inactive_hotels = $hotels->where('status', strtolower('inactive'))->count();
        $total_users = User::count();
        $cards = [
                [
                    "title" => "Registered Hotels",
                    "value" => $total_hotels,
                    "class" => "primary",
                ],
                [
                    "title" => "Active Hotels",
                    "value" => $active_hotels,
                    "class" => "success",
                ],
                [
                    "title" => "Inactive Hotels",
                    "value" => $inactive_hotels,
                    "class" => "warning",
                ],
                [
                    "title" => "Total Users",
                    "value" => $total_users,
                    "class" => "info",
                ],

        ];
        return  $cards;
    }
}