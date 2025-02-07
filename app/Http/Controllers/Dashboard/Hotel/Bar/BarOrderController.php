<?php

namespace App\Http\Controllers\Dashboard\Hotel\Bar;

use App\Constants\CurrencyConstants;
use App\Services\Dashboard\Hotel\Bar\BarOrderService;
use App\Http\Controllers\Controller;
use App\Models\HotelSoftware\barItem;
use App\Models\HotelSoftware\BarOrder;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class BarOrderController extends Controller
{
    protected $bar_order_service;
    public function __construct(BarOrderService $bar_order_service)
    {
        $this->bar_order_service = $bar_order_service;
    }

    public function viewOrders()
    {
        $hotel = User::getAuthenticatedUser()->hotel->id;
        return view('dashboard.hotel.bar-items.order.index', [
            'bar_orders' => BarOrder::with('barOrderItems', 'guest', 'walkInCustomer')
                ->where('hotel_id', $hotel)
                ->latest()
                ->paginate(),
                'payableType' => get_class(new barOrder()),
                'currencies' => CurrencyConstants::CURRENCY_CODES,
        ]);
    }
    public function createOrder()
    {
        $hotel = User::getAuthenticatedUser()->hotel;
        $outlets = $hotel->outlet->where('type', 'bar')->pluck('id'); // Get outlet IDs
        // Fetch all distinct categories
        $categories = BarItem::select('category')->whereIn('outlet_id', $outlets)->distinct()->get();
        // Fetch all items and group them by category after retrieving the data
        $items = BarItem::whereIn('outlet_id', $outlets)->get();
        // Group items by category
        $itemsByCategory = $items->groupBy('category');
        return view('dashboard.hotel.bar-items.order.create', compact('categories', 'itemsByCategory'));
    }

    public function saveOrder(Request $request)
    {
        // dd($request->all());
        try {
            $message = $this->bar_order_service->saveOrder($request);
            return response()->json(['success' => true, 'message' => $message]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage(),], 500); // Send a 500 response on error
        } catch (\Throwable $th) {
            throw $th;
            return response()->json(['success' => false, 'message' => 'Something went wrong while trying to save order',], 500);
        }
    }

    public function editOrder() {}

    public function deleteOrder($order)
    {
        try {
            $this->bar_order_service->deleteOrder($order);
            return response()->json(['success' => true, 'message' => "Order deleted successfully",]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'Order not found',], 404);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage(),], 500);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => 'Something went wrong while trying to save order',], 500);
        }
    }

    public function cancelOrder($order)
    {
        try {
            $this->bar_order_service->cancelOrder($order);
            return response()->json(['success' => true, 'message' => "Order cancelled successfully",  'redirectUrl' => route('dashboard.hotel.bar.view-orders')]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'Order not found', ], 404);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage(),], 500);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => 'Something went wrong while trying to save order',], 500);
        }
    }
}
