<?php

namespace App\Providers;

use App\Models\hotelSoftware\Notification;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Pagination\Paginator;
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

            view()->composer([
                "dashboards.admin.layout.includes.header"
            ], function ($view) {
              
                $view->with([
                   
                ]);
            });
    }
    // View::composer('*', function ($view) {
    //     $countNotification = (new Notification())->countNotification();
    //     $view->with('countNotification', $countNotification);
    // });

}
