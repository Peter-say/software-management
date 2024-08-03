<?php

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\OnboardingController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth', 'verified')->group(function () {
    Route::get('dashboard/home', [DashboardController::class, 'dashboard'])
        ->middleware(['auth', 'verified'])
        ->name('dashboard.home');

    Route::prefix('onboarding')->as('onboarding.')->group(function () {
        Route::get('setup-app', [OnboardingController::class, 'setupApp'])->name('setup-app');
        Route::post('save-setup-app', [OnboardingController::class, 'saveSetupApp'])->name('save-setup-app');

    });
});
