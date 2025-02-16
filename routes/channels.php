<?php

use App\Models\HotelSoftware\HotelUser;
use App\Providers\RoleServiceProvider;
use App\Services\RoleService\HotelServiceRole;
use Illuminate\Support\Facades\Broadcast;

// Broadcast::channel('kitchen-orders', function ($user) {
//     return (new HotelServiceRole($user))->userCanAccessSalesRole($user);
// });
// Broadcast::channel('item-requisition', function ($user) {
//     return (new HotelServiceRole($user))->userCanAccessSalesRole($user);
// });
