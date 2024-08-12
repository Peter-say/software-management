<?php

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\Hotel\RoomController;
use App\Http\Controllers\Dashboard\Hotel\UsersController;
use App\Http\Controllers\Dashboard\OnboardingController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth', 'verified')->group(function () {

    Route::prefix('dashboard')->as('dashboard.')->group(function () {
        Route::get('home', [DashboardController::class, 'dashboard'])->name('home');

        Route::prefix('hotel-users')->as('hotel-users.')->group(function () {
            Route::get('overview', [UsersController::class, 'overview'])->name('overview');
            Route::get('create', [UsersController::class, 'create'])->name('create');
            Route::post('store', [UsersController::class, 'store'])->name('store');
            Route::get('/dashboard/{id}/edit', [UsersController::class, 'edit'])->name('edit');
            Route::put('/dashboard/{id}', [UsersController::class, 'update'])->name('update');
            Route::delete('/{id}/delete', [UsersController::class, 'delete'])->name('delete');
        });
        Route::prefix('hotel')->as('hotel.')->group(function () {
            Route::resource('rooms', RoomController::class);
        });
    });

    Route::prefix('onboarding')->as('onboarding.')->group(function () {
        Route::get('setup-app', [OnboardingController::class, 'setupApp'])->name('setup-app');
        Route::post('save-setup-app', [OnboardingController::class, 'saveSetupApp'])->name('save-setup-app');
    });
});
