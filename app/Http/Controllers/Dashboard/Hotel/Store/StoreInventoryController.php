<?php

namespace App\Http\Controllers\Dashboard\Hotel\Store;

use App\Http\Controllers\Controller;
use App\Models\HotelSoftware\StoreInventory;
use App\Models\User;
use Illuminate\Http\Request;

class StoreInventoryController extends Controller
{
    public function incoming()
    {
        $hotel = User::getAuthenticatedUser()->hotel;
        $inventories = StoreInventory::with('storeItem')->where('hotel_id', $hotel->id)
        ->where('movement_type', 'incoming')
        ->where('store_id', $hotel->store->id)
        ->latest()->paginate(30);
        return view('dashboard.hotel.Store-inventory.incoming', [
            'inventories' => $inventories,
            'sn' => $inventories->firstItem(),
        ]);
    }

    public function outgoing()
    {
        $hotel = User::getAuthenticatedUser()->hotel;
        $inventories = StoreInventory::with('storeItem')->where('hotel_id', $hotel->id)
        ->where('store_id', $hotel->store->id)
        ->where('movement_type', 'outgoing')
        ->latest()->paginate(30);
        return view('dashboard.hotel.Store-inventory.outgoing', [
            'inventories' => $inventories,
            'sn' => $inventories->firstItem(),
        ]);
    }
}
