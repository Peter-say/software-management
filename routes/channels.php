<?php

use App\Models\HotelSoftware\HotelUser;
use App\Providers\RoleServiceProvider;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('kitchen-orders', function ($user) {
    return (new RoleServiceProvider($user))->userCanAccessSalesRole($user);
});
