<?php

use App\Models\HotelSoftware\HotelUser;
use App\Providers\RoleProvider;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('kitchen-orders', function ($user) {
    (new RoleProvider($user))->acessSalesRole();
});
