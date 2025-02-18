<?php

namespace App\Providers;

use App\Models\HotelSoftware\HotelPaymentPlatform;
use App\Models\hotelSoftware\Notification;
use App\Models\HotelSoftware\PaymentPlatform;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();
        // Route::middleware('api')
        //     ->prefix('api')
        //     ->group(base_path('routes/api.php'));

        Route::middleware('web')
            ->group(base_path('routes/web.php'));

        // Register the custom route file
        Route::middleware('web')
            ->group(base_path('routes/dashboard.php'));

            view()->composer('*', function ($view) {
              
                $user = Auth::user(); 

                if ($user && $user->hotel) {
                    $paymentPlatform = HotelPaymentPlatform::where('hotel_id', $user->hotel->id)
                    ->with('paymentPlatform')
                    ->first();
                } else {
                    $paymentPlatform = null; 
                }
        
                $view->with('payment_platform', $paymentPlatform);
            });
    }

}
