<?php

namespace App\Providers;

use App\Models\HotelSoftware\HotelUser;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class RoleProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
       $this->acessSalesRole();
    }

    public function acessSalesRole()
    {
        Gate::define('access-sales', function ($user) {
            $hotelUser = HotelUser::where('user_id', $user->id)->first();
            return $hotelUser->role === 'Hotel_Owner' || $hotelUser->role === 'Manager'|| $hotelUser->role === 'Sales';
        });
    }
}
