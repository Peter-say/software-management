<?php

namespace App\Providers;

use App\Models\HotelSoftware\HotelModulePreference;
use App\Models\HotelSoftware\HotelUser;
use Illuminate\Support\Facades\Auth;
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
        // Gate to check access to a specific module by slug
        Gate::define('view-module', function ($user, $moduleSlug) {
            $hotelUser = $user->hotelUser;
            $hotel = $hotelUser ? $hotelUser->hotel : null;
            return $hotel && $hotel->modulePreferences()->where('slug', $moduleSlug)->exists();
        });
    }

    public function userCanAccessSalesRole()
    {
        return ['Hotel_Owner', 'Manager', 'Sales'];
    }
}
