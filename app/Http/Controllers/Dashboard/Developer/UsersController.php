<?php

namespace App\Http\Controllers\Dashboard\Developer;

use App\Http\Controllers\Controller;
use App\Models\HotelSoftware\HotelUser;
use App\Models\User;
use App\Services\Dashboard\Developer\UsersService;

class UsersController extends Controller
{
    public function index()
    {
        $users = (new UsersService)->getAllHotelAndRegularUsers();
        // dd( $users);
        return view('dashboard.developer.users.index', [
            'users' => $users,
        ]);
    }
}
