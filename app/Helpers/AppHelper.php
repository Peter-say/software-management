<?php

use App\Constants\CurrencyConstants;
use App\Models\Currency;
use App\Models\HotelSoftware\ExpenseCategory;
use App\Models\HotelSoftware\ExpenseItem;
use App\Models\HotelSoftware\Guest;
use App\Models\HotelSoftware\HotelCurrency;
use App\Models\HotelSoftware\ItemCategory;
use App\Models\HotelSoftware\ItemSubCategory;
use App\Models\HotelSoftware\Outlet;
use App\Models\HotelSoftware\Room;
use App\Models\HotelSoftware\StoreItem;
use App\Models\HotelSoftware\Supplier;
use App\Models\HotelSoftware\WalkInCustomer;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Torann\GeoIP\Facades\GeoIP;

function getModelItems($model)
{
    $model_list = null;

    $hotel_id = User::getAuthenticatedUser()->hotel?->id;

    if ($model == 'countries') {
        $model_list = DB::table('countries')->select('id', 'name')->orderBy('name', 'asc')->get();
    } elseif ($model == 'states') {
        $model_list = DB::table('states')->select('id', 'name')->orderBy('name', 'asc')->get();
    } elseif ($model == 'currencies') {
        $model_list = DB::table('currencies')->orderBy('name', 'asc')->get();
    } elseif ($model == 'rooms') {
        $model_list = Room::where('hotel_id', $hotel_id)->get();
    } elseif ($model == 'guests') {
        $model_list = Guest::where('hotel_id', $hotel_id)->get();
    } elseif ($model == 'restaurant-outlets') {
        $model_list = Outlet::where('hotel_id', $hotel_id)->where('type', 'restaurant')->get();
    } elseif ($model == 'bar-outlets') {
        $model_list = Outlet::where('hotel_id', $hotel_id)->where('type', 'bar')->get();
    } elseif ($model == 'suppliers') {
        $model_list = Supplier::where('hotel_id', $hotel_id)->get();
    } elseif ($model == 'expense-categories') {
        $model_list = ExpenseCategory::where('hotel_id', $hotel_id)->get();
    } elseif ($model == 'expense-items') {
        $model_list = ExpenseItem::where('hotel_id', $hotel_id)->get();
    } elseif ($model == 'store-items') {
        $model_list = StoreItem::whereHas('store', function ($query) use ($hotel_id) {
            $query->where('hotel_id', $hotel_id);
        })->get();
    } elseif ($model == 'outlets') {
        $model_list = Outlet::where('hotel_id', $hotel_id)->get();
    } elseif ($model == 'walk_in_customers') {
        // Get the outlet (restaurant) for the hotel
        $model_list = Outlet::where('hotel_id', $hotel_id)->where('type', 'restaurant')->first();

        $model_list = WalkInCustomer::whereHas('restaurantOrders', function ($query) use ($hotel_id) {
            $query->where('hotel_id', $hotel_id);
        })->orWhereHas('barOrders', function ($query) use ($hotel_id) {
            $query->where('hotel_id', $hotel_id);
        })->distinct()->get();
    }
    if ($model == 'item-categories') {
        $model_list = ItemCategory::all();
    }
    if ($model == 'item-sub_categories') {
        $model_list = ItemSubCategory::all();
    }
    return $model_list;
}

function getStatusAsString(int $status): string
{
    if ($status === 1) {
        return 'Active';
    } else {
        return 'Inactive';
    }
}
function getItemAvailability(int $status): string
{
    if ($status === 1) {
        return 'Available';
    } else {
        return 'Not Available';
    }
}
function getStatuses($status = null)
{
    $statuses = [
        'pending' => [
            'icon' => 'fas fa-hourglass-start',
            'color' => 'text-warning',
            'label' => 'Pending'
        ],
        'in_progress' => [
            'icon' => 'fas fa-spinner',
            'color' => 'text-info',
            'label' => 'In Progress'
        ],
        'ready' => [
            'icon' => 'fas fa-check',
            'color' => 'text-success',
            'label' => 'Ready'
        ],
    ];
    if ($status) {
        return $statuses[$status] ?? null;
    }

    return $statuses;
}


function formatNumber($number)
{
    if ($number >= 1000000) {
        return number_format($number / 1000000, 1) . 'M';
    } elseif ($number >= 1000) {
        return number_format($number / 1000, 1) . 'K';
    } else {
        return number_format($number);
    }
}

if (!function_exists('getStorageUrl')) {
    function getStorageUrl($relativePath)
    {
        if (app()->environment('local')) {
            return url($relativePath);  
        } else {
            return url("public/{$relativePath}");
        }
    }
}

if (!function_exists('getStoragePath')) {
    function getStoragePath($relativePath)
    {
        if (app()->environment('local')) {
            return public_path($relativePath);
        } else {
            return public_path($relativePath);
        }
    }
}



function getCountry()
{
    $ip = request()->ip();
    if ($ip === '127.0.0.1' || $ip === '::1') {
        return 'Nigeria';
    }
    $url = "http://ip-api.com/json/{$ip}";
    $response = file_get_contents($url);
    $location = json_decode($response, true);

    return $location['status'] === 'success' ? $location['country'] : 'Unknown';
}
function getCountryCurrency()
{
    $hotel = User::getAuthenticatedUser()->hotel;
    $country_currency = HotelCurrency::where('hotel_id', $hotel->id)->first()?->currency->short_name;
    $location_currency = getCountry();
    $currency_code = array_search($location_currency, CurrencyConstants::CURRENCY_MAPPING) ?: 'USD';
    return $country_currency ?: $currency_code;
}

function getHotelCurrency()
{
    $hotel = User::getAuthenticatedUser()->hotel;
    $hotel_currency = HotelCurrency::where('hotel_id', $hotel->id)->first()?->currency;
    $location_currency = getCountry();
    $currency_code = array_search($location_currency, CurrencyConstants::CURRENCY_MAPPING) ?: 'USD';
    $default_currency = Currency::where('short_name', $currency_code)->first();
    return $hotel_currency ?:  $default_currency;
}

function currencySymbol()
{
    return getHotelCurrency()?->symbol;
}
