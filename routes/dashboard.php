<?php

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\Finance\PaymentController;
use App\Http\Controllers\Dashboard\Hotel\ExpenseController;
use App\Http\Controllers\Dashboard\Hotel\Guest\GuestController;
use App\Http\Controllers\Dashboard\Hotel\Guest\GuestWalletController;
use App\Http\Controllers\Dashboard\Hotel\Invoices\Guest\RoomReservationInvoiceController;
use App\Http\Controllers\Dashboard\Hotel\Kitchen\KitchenOrderController;
use App\Http\Controllers\Dashboard\Hotel\ModulePreferenceController;
use App\Http\Controllers\Dashboard\Hotel\OutletController;
use App\Http\Controllers\Dashboard\Hotel\PurchaseController;
use App\Http\Controllers\Dashboard\Hotel\RequisitionController;
use App\Http\Controllers\Dashboard\Hotel\Restaurant\RestaurantItemsController;
use App\Http\Controllers\Dashboard\Hotel\Restaurant\RestaurantOrderController;
use App\Http\Controllers\Dashboard\Hotel\RoomController;
use App\Http\Controllers\Dashboard\Hotel\RoomReservationController;
use App\Http\Controllers\Dashboard\Hotel\StoreItemController;
use App\Http\Controllers\Dashboard\Hotel\SupplierController;
use App\Http\Controllers\Dashboard\Hotel\UsersController;
use App\Http\Controllers\Dashboard\Notification\NotificationController;
use App\Http\Controllers\Dashboard\OnboardingController;
use App\Http\Controllers\Dashboard\Settings\HotelSettingController;
use App\Http\Controllers\Dashboard\Settings\SettingController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth', 'verified')->group(function () {

    Route::prefix('dashboard')->as('dashboard.')->group(function () {
        Route::get('download.sample', [RestaurantItemsController::class, 'downloadSample'])->name('download.sample');

        Route::get('home', [DashboardController::class, 'dashboard'])->name('home');
        Route::get('load-more-recent-reservation', [DashboardController::class, 'loadRecentReservation'])->name('load-more-recent-reservation');

        Route::prefix('hotel-users')->as('hotel-users.')->group(function () {
            Route::get('overview', [UsersController::class, 'overview'])->name('overview');
            Route::get('create', [UsersController::class, 'create'])->name('create');
            Route::post('store', [UsersController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [UsersController::class, 'edit'])->name('edit');
            Route::put('/{id}', [UsersController::class, 'update'])->name('update');
            Route::delete('/{id}/delete', [UsersController::class, 'delete'])->name('delete');
            Route::get('/search', [UsersController::class, 'search'])->name('search');
        });
        Route::prefix('hotel')->as('hotel.')->group(function () {
            Route::resource('rooms', RoomController::class);
            Route::resource('reservations', RoomReservationController::class);
            Route::resource('guests', GuestController::class);
            Route::resource('restaurant-items', RestaurantItemsController::class);
            Route::resource('outlets', OutletController::class);
            Route::resource('suppliers', SupplierController::class);
            Route::resource('expenses', ExpenseController::class);
            Route::resource('module-preferences', ModulePreferenceController::class);
            Route::resource('purchases', PurchaseController::class);
            Route::resource('store-items', StoreItemController::class);
            Route::resource('requisitions', RequisitionController::class);

            Route::get('set-guest-info', [GuestController::class, 'getGuestInfo'])->name('set-guest-info');
            Route::post('check-room-availability', [RoomReservationController::class, 'getRoomAvailability']);

            Route::put('reservation/{id}/check-in-guest', [RoomReservationController::class, 'checkInGuest'])->name('reservation.check-in-guest');
            Route::put('reservation/{id}/check-out-guest', [RoomReservationController::class, 'CheckOutGuest'])->name('reservation.check-out-guest');

            Route::post('fund-guest-wallet', [GuestWalletController::class, 'creditGuestWallet'])->name('fund-guest-wallet');
            Route::post('deduct-guest-wallet', [GuestWalletController::class, 'recordDebitTransaction'])->name('deduct-guest-wallet');
            Route::post('pay-with-guest-wallet', [GuestWalletController::class, 'payWithGuestWallet'])->name('pay-with-guest-wallet');

            Route::get('reservation/print/{id}/invoice-pdf', [RoomReservationInvoiceController::class, 'printInvoicePDF'])->name('reservation.print.invoice-pdf');

            Route::post('restaurant-items/upload', [RestaurantItemsController::class, 'importItems'])->name('restaurant-items.upload');
            Route::delete('restaurant-items/truncate', [RestaurantItemsController::class, 'truncateItems'])->name('restaurant-items.truncate');
            Route::get('restaurant/create-order', [RestaurantOrderController::class, 'createOrder'])->name('restaurant.create-order');
            Route::post('restaurant/save-order', [RestaurantOrderController::class, 'saveOrder'])->name('restaurant.save-order');
            Route::get('restaurant/view-orders', [RestaurantOrderController::class, 'viewOrders'])->name('restaurant.view-orders');
            Route::get('restaurant/edit-order', [RestaurantOrderController::class, 'editOrder'])->name('restaurant.edit-order');
            Route::delete('restaurant/destroy-order', [RestaurantOrderController::class, 'destroyOrder'])->name('restaurant.destroy-order');
            Route::post('restaurant/{id}/cancel-order', [RestaurantOrderController::class, 'cancelOrder'])->name('restaurant.cancel-order');

            Route::get('kitchen/orders', [KitchenOrderController::class, 'viewOrders'])->name('kitchen.orders');
            Route::put('kitchen/orders/{id}/change-status', [KitchenOrderController::class, 'updateStatus'])->name('kitchen.orders.change-status');
            Route::put('kitchen/orders/{id}/add-note', [KitchenOrderController::class, 'addNote'])->name('kitchen.orders.add-note');
            Route::put('kitchen/orders/{id}/assign-task', [KitchenOrderController::class, 'assignTask'])->name('kitchen.orders.assign-task');

            Route::get('notifications/unread', [NotificationController::class, 'unread'])->name('notifications.unread');
            Route::post('notifications/mark-as-read/{id}', [NotificationController::class, 'makeAsRead'])->name('notifications.mark-as-read');
            Route::get('notifications/{uuid}/view', [NotificationController::class, 'view'])->name('notifications.view');
            Route::get('notifications/view-all', [NotificationController::class, 'viewAll'])->name('notifications.view-all');
            Route::get('notifications/fetch-all', [NotificationController::class, 'fetchAll'])->name('notifications.fetch-all');
            Route::delete('/notifications/{id}/delete', [NotificationController::class, 'deleteNotification'])->name('notifications.delete');
            Route::delete('/notifications/delete-bulk', [NotificationController::class, 'deleteBulk'])->name('notifications.delete-bulk');

            Route::get('/expenses-dashbaord', [ExpenseController::class, 'dashboard'])->name('expenses-dashbaord');
            Route::get('/purchases-dashbaord', [PurchaseController::class, 'overview'])->name('purchases-dashbaord');

            Route::prefix('settings')->as('settings.')->group(function () {
                Route::get('/', [SettingController::class, 'index']);
                Route::prefix('hotel-info')->as('hotel-info.')->group(function () {
                    Route::get('/', [HotelSettingController::class, 'index']);
                });
            });
        });
        Route::prefix('payments')->as('payments.')->group(function () {
            Route::post('pay-with-card', [PaymentController::class, 'payWithCard'])->name('pay-with-card');
        });
    });
    Route::get('/get-states-by-country', [OnboardingController::class, 'getStatesByCountry'])->name('get-states-by-country');

    Route::prefix('onboarding')->as('onboarding.')->group(function () {
        Route::get('setup-app', [OnboardingController::class, 'setupApp'])->name('setup-app');
        Route::post('save-setup-app', [OnboardingController::class, 'saveSetupApp'])->name('save-setup-app');
    });
});
