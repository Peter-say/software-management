<?php

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\Hotel\Guest\GuestController;
use App\Http\Controllers\Dashboard\Hotel\Guest\GuestWalletController;
use App\Http\Controllers\Dashboard\Hotel\Invoices\Guest\RoomReservationInvoiceController;
use App\Http\Controllers\Dashboard\Hotel\Restaurant\RestaurantItemsController;
use App\Http\Controllers\Dashboard\Hotel\Restaurant\RestaurantOrderController;
use App\Http\Controllers\Dashboard\Hotel\RoomController;
use App\Http\Controllers\Dashboard\Hotel\RoomReservationController;
use App\Http\Controllers\Dashboard\Hotel\UsersController;
use App\Http\Controllers\Dashboard\OnboardingController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth', 'verified')->group(function () {

    Route::prefix('dashboard')->as('dashboard.')->group(function () {
        Route::get('download.sample', [RestaurantItemsController::class, 'downloadSample'])->name('download.sample');

        Route::get('home', [DashboardController::class, 'dashboard'])->name('home');

        Route::prefix('hotel-users')->as('hotel-users.')->group(function () {
            Route::get('overview', [UsersController::class, 'overview'])->name('overview');
            Route::get('create', [UsersController::class, 'create'])->name('create');
            Route::post('store', [UsersController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [UsersController::class, 'edit'])->name('edit');
            Route::put('/{id}', [UsersController::class, 'update'])->name('update');
            Route::delete('/{id}/delete', [UsersController::class, 'delete'])->name('delete');
        });
        Route::prefix('hotel')->as('hotel.')->group(function () {
            Route::resource('rooms', RoomController::class);
            Route::resource('reservations', RoomReservationController::class);
            Route::resource('guests', GuestController::class);
            Route::resource('restaurant-items', RestaurantItemsController::class);
            Route::get('set-guest-info', [GuestController::class, 'getGuestInfo'])->name('set-guest-info');
            Route::post('check-room-availability', [RoomReservationController::class, 'getRoomAvailability']);

            Route::put('reservation/{id}/check-in-guest', [RoomReservationController::class, 'checkInGuest'])->name('reservation.check-in-guest');
            Route::put('reservation/{id}/check-out-guest', [RoomReservationController::class, 'CheckOutGuest'])->name('reservation.check-out-guest');

            Route::post('fund-guest-wallet', [GuestWalletController::class, 'creditGuestWallet'])->name('fund-guest-wallet');
            Route::post('deduct-guest-wallet', [GuestWalletController::class, 'recordDebitTransaction'])->name('deduct-guest-wallet');
            Route::post('pay-with-guest-wallet', [GuestWalletController::class, 'payWithGuestWallet'])->name('pay-with-guest-wallet');
    
            Route::get('reservation/print/{id}/invoice-pdf', [RoomReservationInvoiceController::class, 'printInvoicePDF'])->name('reservation.print.invoice-pdf');

            Route::post('restaurant-items/upload', [RestaurantItemsController::class, 'importItems'])->name('restaurant-items.upload');
            Route::get('restaurant/create-order', [RestaurantOrderController::class, 'createOrder'])->name('restaurant.create-order');
            Route::post('restaurant/save-order', [RestaurantOrderController::class, 'saveOrder'])->name('restaurant.save-order');
        });
           
    });
    Route::get('/get-states-by-country', [OnboardingController::class, 'getStatesByCountry'])->name('get-states-by-country');

    Route::prefix('onboarding')->as('onboarding.')->group(function () {
        Route::get('setup-app', [OnboardingController::class, 'setupApp'])->name('setup-app');
        Route::post('save-setup-app', [OnboardingController::class, 'saveSetupApp'])->name('save-setup-app');
    });
});
