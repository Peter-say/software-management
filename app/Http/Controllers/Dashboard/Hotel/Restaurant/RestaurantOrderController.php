<?php

namespace App\Http\Controllers\Dashboard\Hotel\Restaurant;

use App\Services\Dashboard\Hotel\Restaurant\RestaurantOrderService;
use App\Http\Controllers\Controller;
use App\Models\HotelSoftware\Guest;
use App\Models\HotelSoftware\Outlet;
use App\Models\HotelSoftware\RestaurantItem;
use App\Models\HotelSoftware\RestaurantOrder;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class RestaurantOrderController extends Controller
{
    protected $restaurant_order_service;
    public function __construct(RestaurantOrderService $restaurant_order_service)
    {
        $this->restaurant_order_service = $restaurant_order_service;
    }

    public function viewOrders()
    {
        $hotel = User::getAuthenticatedUser()->hotel->id;
        // $restaurant_orders = RestaurantOrder::with('restaurantOrderItems', 'guest', 'walkInCustomer') ->where('hotel_id', $hotel)->get();
        // dd($restaurant_orders);
        return view('dashboard.hotel.restaurant-item.order.index', [
            'restaurant_orders' => RestaurantOrder::with('restaurantOrderItems', 'guest', 'walkInCustomer')
                ->where('hotel_id', $hotel)
                ->paginate(),
        ]);
    }
    public function createOrder()
    {
        $hotel = User::getAuthenticatedUser()->hotel;
        $outlets = $hotel->outlet->where('type', 'restaurant')->pluck('id'); // Get outlet IDs
        // Fetch all distinct categories
        $categories = RestaurantItem::select('category')->whereIn('outlet_id', $outlets)->distinct()->get();
        // Fetch all items and group them by category after retrieving the data
        $items = RestaurantItem::whereIn('outlet_id', $outlets)->get();
        // Group items by category
        $itemsByCategory = $items->groupBy('category');
        return view('dashboard.hotel.restaurant-item.order.create', compact('categories', 'itemsByCategory'));
    }

    public function saveOrder(Request $request)
    {
        try {
            $message = $this->restaurant_order_service->saveOrder($request);
            return response()->json([
                'success' => true,
                'message' => $message,
            ]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage(),], 500); // Send a 500 response on error
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong while trying to save order',
            ], 500);
        }
    }

    public function editOrder() {}

    public function deleteOrder() {}

    public function cancelOrder() {}
}
