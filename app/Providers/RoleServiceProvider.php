<?php

namespace App\Providers;

use App\Models\HotelSoftware\HotelUser;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class RoleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Register any application services
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->defineGates();
    }

    protected function defineGates()
    {
        Gate::define('access-sales', function ($user) {
            $hotelUser = HotelUser::where('user_id', $user->id)->first();
            return $hotelUser && (
                $hotelUser->role === 'Hotel_Owner' || 
                $hotelUser->role === 'Manager' || 
                $hotelUser->role === 'Sales'
            );
        });
    }

    public function userCanAccessSalesRole($user)
    {
        $hotelUser = HotelUser::where('user_id', $user->id)->first();
        if ($hotelUser && in_array($hotelUser->role, ['Hotel_Owner', 'Manager', 'Sales'])) {
            return $hotelUser->role;
        }
        return null;
    }
    
}