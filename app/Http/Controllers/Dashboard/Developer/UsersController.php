<?php

namespace App\Http\Controllers\Dashboard\Developer;

use App\Http\Controllers\Controller;
use App\Models\User;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();
        return view('dashboard.developer.users.index', [
            'users' => $users,
        ]);
    }
}
