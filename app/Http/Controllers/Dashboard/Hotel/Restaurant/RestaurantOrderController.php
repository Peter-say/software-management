<?php

namespace App\Http\Controllers\Dashboard\Hotel\Restaurant;
use App\Services\Dashboard\Hotel\Restaurant\RestaurantOrderService;
use App\Http\Controllers\Controller;
use App\Models\HotelSoftware\Guest;
use App\Models\HotelSoftware\Outlet;
use App\Models\HotelSoftware\RestaurantItem;
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
    public function createOrder()
    {
          // Fetch all distinct categories
          $categories = RestaurantItem::select('category')->distinct()->get();
          // Fetch all items and group them by category
          $itemsByCategory = RestaurantItem::all()->groupBy('category');
          $guests = Guest::all();
          $outlets = Outlet::where('id', User::getAuthenticatedUser()->hotel->id)->where('type', 'restaurant')->get();
        return view('dashboard.hotel.restaurant-item.order.create', compact('categories', 'itemsByCategory', 'guests', 'outlets'));
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
}
