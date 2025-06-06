<?php

namespace App\Http\Controllers\Dashboard\Hotel\Kitchen;

use App\Http\Controllers\Controller;
use App\Models\HotelSoftware\Hotel;
use App\Models\HotelSoftware\KitchenOrder;
use App\Models\HotelSoftware\RestaurantOrder;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class KitchenOrderController extends Controller
{
    public function viewOrders()
    {
        $hotel = User::getAuthenticatedUser()->hotel;
        $staffs = $hotel->hotelUsers;
        $restaurantOrders = RestaurantOrder::where('hotel_id', $hotel->id)->pluck('id');
        // $kitchen_orders = KitchenOrder::whereIn('order_id', $restaurantOrders)->paginate();
        return view('dashboard.hotel.kitchen.orders', [
            'kitchen_orders' => KitchenOrder::whereIn('order_id', $restaurantOrders)
            ->with(['restaurantOrder', 'user'])->paginate(),
            'staffs' => $staffs,
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'status' => 'required|in:ready,in_progress,pending',
            ]);

            $kitchen = $this->getById($id);
            $kitchen->update(['status' => $validatedData['status']]);

            return back()->with('success_message', 'Order status updated successfully');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error_message', 'Order not found.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error_message', 'An error occurred while updating the order: ' . $e->getMessage());
        }
    }

    public function addNote(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'notes' => 'nullable|string|max:1000',
            ]);
            $kitchen = $this->getById($id);
            $kitchen->update([
                'notes' => $validatedData['notes'] ?? $kitchen->notes,
            ]);

            return back()->with('success_message', 'Noted added successfully');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        }  catch (\Exception $e) {
            return redirect()->back()->with('error_message', 'An error occurred additing note');
        }
    }

    public function assignTask(Request $request, $id)
    {
        // dd($request->all());
        try {
            $validatedData = $request->validate([
                'user_id' => 'required|string',
            ]);
            $kitchen = $this->getById($id);
            $kitchen->update([
                'user_id' => $validatedData['user_id'],
            ]);

            return back()->with('success_message', 'Task assigned to '  . $kitchen->user->name . ' successfully');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        }  catch (\Exception $e) {
            throw $e;
            return redirect()->back()->with('error_message', 'An error occurred assigning task');
        }
    }

    public function getById($id)
    {
        $order = KitchenOrder::find($id);
        if (empty($order)) {
            throw new ModelNotFoundException("Order not found");
        }
        return $order;
    }
}
