<?php

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\Developer\HotelsController;
use App\Http\Controllers\Dashboard\Developer\UsersController as DeveloperUsersController;
use App\Http\Controllers\Dashboard\Finance\PaymentController;
use App\Http\Controllers\Dashboard\Hotel\Bar\BarItemsController;
use App\Http\Controllers\Dashboard\Hotel\Bar\BarOrderController;
use App\Http\Controllers\Dashboard\Hotel\ExpenseController;
use App\Http\Controllers\Dashboard\Hotel\Guest\GuestController;
use App\Http\Controllers\Dashboard\Hotel\Guest\GuestWalletController;
use App\Http\Controllers\Dashboard\Hotel\Invoices\Guest\RoomReservationInvoiceController;
use App\Http\Controllers\Dashboard\Hotel\Kitchen\KitchenOrderController;
use App\Http\Controllers\Dashboard\Hotel\ManageCurrencyController;
use App\Http\Controllers\Dashboard\Hotel\ModulePreferenceController;
use App\Http\Controllers\Dashboard\Hotel\OutletController;
use App\Http\Controllers\Dashboard\Hotel\PaymentPlatformController;
use App\Http\Controllers\Dashboard\Hotel\PurchaseController;
use App\Http\Controllers\Dashboard\Hotel\RequisitionController;
use App\Http\Controllers\Dashboard\Hotel\Restaurant\RestaurantItemsController;
use App\Http\Controllers\Dashboard\Hotel\Restaurant\RestaurantOrderController;
use App\Http\Controllers\Dashboard\Hotel\RoomController;
use App\Http\Controllers\Dashboard\Hotel\RoomReservationController;
use App\Http\Controllers\Dashboard\Hotel\Store\StoreController;
use App\Http\Controllers\Dashboard\Hotel\Store\StoreInventoryController;
use App\Http\Controllers\Dashboard\Hotel\Store\StoreIssueController;
use App\Http\Controllers\Dashboard\Hotel\Store\StoreItemController;
use App\Http\Controllers\Dashboard\Hotel\SupplierController;
use App\Http\Controllers\Dashboard\Hotel\UsersController;
use App\Http\Controllers\Dashboard\Notification\NotificationController;
use App\Http\Controllers\Dashboard\OnboardingController;
use App\Http\Controllers\Dashboard\Settings\HotelSettingController;
use App\Http\Controllers\Dashboard\Settings\SettingController;
use App\Http\Middleware\HotelUserMiddleware;
use App\Models\HotelSoftware\PaymentPlatform;
use App\Models\HotelSoftware\StoreInventory;
use Illuminate\Support\Facades\Route;


Route::middleware('auth', 'verified')->group(function () {

    Route::prefix('dashboard')->as('dashboard.')->group(function () {

        Route::prefix('hotels')->as('hotels.')->group(function () {
            Route::get('/', [HotelsController::class, 'index']);
            Route::get('/show-hotel/{id}', [HotelsController::class, 'show'])->name('show-hotel');
            Route::delete('/delete-hotel/{id}', [HotelsController::class, 'delete'])->name('delete-hotel');
            Route::post('/login-as-hotel-owner/{id}', [HotelsController::class, 'loginAsHotelOwner'])->name('login-as-hotel-owner');
            Route::get('/impersonate/{id}', [HotelsController::class, 'impersonate'])
                ->name('impersonate')->middleware('signed');
            Route::post('/switch-back-impersonator', [HotelsController::class, 'switchBackImpersonator'])->name('switch-back-impersonator');
        });
        Route::prefix('users')->as('users.')->group(function () {
            Route::get('/', [DeveloperUsersController::class, 'index']);
        });

        Route::get('download.sample', [RestaurantItemsController::class, 'downloadSample'])->name('download.sample');

        Route::get('home', [DashboardController::class, 'dashboard'])->name('home');
        Route::get('load-more-recent-reservation', [RoomReservationController::class, 'loadRecentReservation'])->name('load-more-recent-reservation');

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
            Route::resource('bar-items', BarItemsController::class);

            Route::post('/store-payment-platform', [PaymentPlatformController::class, 'store'])->name('store-payment-platform');
            Route::put('/update-payment-platform/{id}', [PaymentPlatformController::class, 'update'])->name('update-payment-platform');

            Route::put('/update-hotel-currency', [ManageCurrencyController::class, 'update'])->name('update-hotel-currency');

            Route::prefix('payments')->as('payments.')->group(function () {
                Route::get('pay', [PaymentController::class, 'pay'])->name('pay');
                Route::get('list', [PaymentController::class, 'list'])->name('list');
                Route::post('initiate', [PaymentController::class, 'initiatePayment'])->name('initiate');
            });

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

            Route::post('bar-items/upload', [BarItemsController::class, 'importItems'])->name('bar-items.upload');
            Route::delete('bar-items/truncate', [BarItemsController::class, 'truncateItems'])->name('bar-items.truncate');
            Route::get('bar/create-order', [BarOrderController::class, 'createOrder'])->name('bar.create-order');
            Route::post('bar/save-order', [BarOrderController::class, 'saveOrder'])->name('bar.save-order');
            Route::get('bar/view-orders', [BarOrderController::class, 'viewOrders'])->name('bar.view-orders');
            Route::get('bar/edit-order', [BarOrderController::class, 'editOrder'])->name('bar.edit-order');
            Route::delete('bar/destroy-order/{order}', [BarOrderController::class, 'deleteOrder'])->name('bar.destroy-order');
            Route::post('bar/{id}/cancel-order', [BarOrderController::class, 'cancelOrder'])->name('bar.cancel-order');

            Route::get('kitchen/orders', [KitchenOrderController::class, 'viewOrders'])->name('kitchen.orders');
            Route::put('kitchen/orders/{id}/change-status', [KitchenOrderController::class, 'updateStatus'])->name('kitchen.orders.change-status');
            Route::put('kitchen/orders/{id}/add-note', [KitchenOrderController::class, 'addNote'])->name('kitchen.orders.add-note');
            Route::put('kitchen/orders/{id}/assign-task', [KitchenOrderController::class, 'assignTask'])->name('kitchen.orders.assign-task');

            Route::get('store-issues/index', [StoreIssueController::class, 'index'])->name('store-issues.index');
            Route::get('store-issues/create', [StoreIssueController::class, 'create'])->name('store-issues.create');
            Route::post('store-issues/store', [StoreIssueController::class, 'store'])->name('store-issues.store');
            Route::get('fetch-store-items', [StoreIssueController::class, 'getItemByCategory'])->name('fetch-store-items');

            Route::prefix('store')->as('store.')->group(function () {
                Route::get('inventory/incoming', [StoreInventoryController::class, 'incoming'])->name('inventory.incoming');
                Route::get('inventory/outgoing', [StoreInventoryController::class, 'outgoing'])->name('inventory.outgoing');
            });


            Route::get('notifications/unread', [NotificationController::class, 'unread'])->name('notifications.unread');
            Route::post('notifications/mark-as-read/{id}', [NotificationController::class, 'makeAsRead'])->name('notifications.mark-as-read');
            Route::get('notifications/{uuid}/view', [NotificationController::class, 'view'])->name('notifications.view');
            Route::get('notifications/view-all', [NotificationController::class, 'viewAll'])->name('notifications.view-all');
            Route::get('notifications/fetch-all', [NotificationController::class, 'fetchAll'])->name('notifications.fetch-all');
            Route::delete('/notifications/{id}/delete', [NotificationController::class, 'deleteNotification'])->name('notifications.delete');
            Route::delete('/notifications/delete-bulk', [NotificationController::class, 'deleteBulk'])->name('notifications.delete-bulk');

            Route::get('/expenses-dashbaord', [ExpenseController::class, 'dashboard'])->name('expenses-dashbaord');
            Route::get('/purchases-dashbaord', [PurchaseController::class, 'overview'])->name('purchases-dashbaord');
            Route::get('store-dashboard', [StoreController::class, 'overview'])->name('store-dashboard');
            Route::get('reservation-dashboard', [RoomReservationController::class, 'overview'])->name('reservation-dashboard');

            Route::prefix('settings')->as('settings.')->group(function () {
                Route::get('/', [SettingController::class, 'index']);
                Route::prefix('hotel-info')->as('hotel-info.')->group(function () {
                    Route::get('/', [HotelSettingController::class, 'index']);
                    Route::get('choose-payment-platform', [HotelSettingController::class, 'paymentPlaform'])->name('choose-payment-platform');
                    Route::get('edit-currency', [HotelSettingController::class, 'editCurrency'])->name('edit-currency');
                    Route::get('edit', [HotelSettingController::class, 'edit'])->name('edit');
                    Route::put('update', [HotelSettingController::class, 'update'])->name('update');
                });
            });
            Route::prefix('filter')->as('filter.')->group(function () {
                Route::get('rooms', [RoomController::class, 'filterRoom'])->name('rooms');
            });
        });
        Route::prefix('payments')->as('payments.')->group(function () {
            Route::get('pay', [PaymentController::class, 'pay'])->name('pay');
            Route::get('list', [PaymentController::class, 'list'])->name('list');
            Route::post('initiate', [PaymentController::class, 'initiatePayment'])->name('initiate');
        });
    })->middleware(HotelUserMiddleware::class);

    Route::get('/get-states-by-country', [OnboardingController::class, 'getStatesByCountry'])->name('get-states-by-country');

    Route::prefix('onboarding')->as('onboarding.')->group(function () {
        Route::get('setup-app', [OnboardingController::class, 'setupApp'])->name('setup-app');
        Route::post('save-setup-app', [OnboardingController::class, 'saveSetupApp'])->name('save-setup-app');
    });
});
