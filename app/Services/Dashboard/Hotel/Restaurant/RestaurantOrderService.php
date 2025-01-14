<?php

namespace App\Services\Dashboard\Hotel\Restaurant;

use App\Constants\StatusConstants;
use App\Models\HotelSoftware\HotelUser;
use App\Models\HotelSoftware\KitchenOrder;
use App\Models\HotelSoftware\RestaurantOrder;
use App\Models\HotelSoftware\RestaurantOrderItem;
use App\Models\HotelSoftware\WalkInCustomer;
use App\Models\User;
use App\Notifications\KitchenOrderNotification;
use App\Providers\RoleServiceProvider;
use App\Services\RoleService\HotelServiceRole;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class RestaurantOrderService
{
    public function validatedData(array $data)
    {
        $validator = Validator::make($data, [
            'outlet_id' => 'required|exists:outlets,id',
            'quantity' => 'required|numeric|min:1',
            'items' => 'required|array',
            'items.*.id' => 'required|exists:restaurant_items,id',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'notes' => 'nullable|string',

            'guest_id' => 'nullable|exists:guests,id',
            'walk_in_customer_id' => 'nullable|exists:walk_in_customers,id',
            'customer_name' => 'nullable|string|max:255',  // Change required_without_all to nullable
            'customer_email' => 'nullable|email',
            'customer_phone' => 'nullable|string|max:15',
        ]);

        // Custom validation to ensure that at least one of guest_id or customer details is provided
        $validator->after(function ($validator) use ($data) {
            // Ensure that at least one of guest_id, walk_in_customer_id, or customer_name is present
            if (empty($data['guest_id']) && empty($data['walk_in_customer_id']) && empty($data['customer_name'])) {
                $validator->errors()->add('customer_name', 'You must select a guest or provide customer details.');
            }
        });

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $validator->validated();
    }


    public function saveOrder(Request $request)
    {
        // dd($request->all()); // Debugging to see the full request data
        $data = $this->validatedData($request->all()); // Validate the data

        $user = User::getAuthenticatedUser();
        $data['user_id'] = $user->id;
        $data['hotel_id'] = $user->hotel->id;
        $data['order_date'] = Carbon::today();

        // Initialize total amount to calculate the total price
        $totalAmount = 0;

        // Loop through items to calculate the amount from each item price
        foreach ($data['items'] as $item) {
            // Ensure the price is taken from each item
            $totalAmount += $item['price'] * $item['quantity'];
        }

        $data['amount'] = $totalAmount;

        // Proceed with guest or walk-in customer handling
        if ($request->guest_id) {
            $data['guest_id'] = $request->guest_id;
        } elseif ($request->walk_in_customer_id) {
            $data['walk_in_customer_id'] = $request->walk_in_customer_id;
        } else {
            $customerData['name'] = $request->customer_name;
            $customerData['email'] = $request->customer_email;
            $customerData['phone'] = $request->customer_phone;
            $customer = WalkInCustomer::create($customerData);
            $data['walk_in_customer_id'] = $customer->id;
        }

        // Set tax details and calculate total
        $data['tax_rate'] = 2; // Example tax rate
        $data['tax_amount'] = $data['amount'] * ($data['tax_rate'] / 100);
        $data['discount_rate'] = 0;
        $data['discount_type'] = 'Loyalty Discounts';
        $data['discount_amount'] = 0.00;
        $data['total_amount'] = $data['amount'] + $data['tax_amount'];

        // Create the restaurant order
        $restaurantOrder = RestaurantOrder::create($data);
        if ($restaurantOrder) {
            $restaurantOrder->update(['status' => StatusConstants::OPENED]);
        }

        // Create Kitchen Order
        KitchenOrder::create([
            'order_id' => $restaurantOrder->id,
        ]);

        // Save the individual items in the restaurant order
        foreach ($data['items'] as $item) {
            RestaurantOrderItem::create([
                'restaurant_order_id' => $restaurantOrder->id,
                'restaurant_item_id' => $item['id'],
                'qty' => $item['quantity'],
                'amount' => $item['price'] * $item['quantity'], // Calculate amount for each item
                'tax_rate' => $data['tax_rate'],
                'tax_amount' => ($item['price'] * $item['quantity']) * ($data['tax_rate'] / 100),
                'discount_rate' => $data['discount_rate'],
                'discount_type' => $data['discount_type'],
                'discount_amount' => 0,
                'total_amount' => ($item['price'] * $item['quantity']) + ($item['price'] * $item['quantity'] * ($data['tax_rate'] / 100)),
            ]);
        }

        // Update total amount in the order
        $restaurantOrder->total_amount = $totalAmount + $data['tax_amount'] - $data['discount_amount'];
        $restaurantOrder->save();

        // Notify kitchen staff
        $user = Auth::user();
        $roleService = new HotelServiceRole();
        $kitchenStaff = HotelUser::whereIn('role', $roleService->userCanAccessSalesRole())->get();
        foreach ($kitchenStaff as $staff) {
            if ($staff->user && $staff->user->email) {
                $staff->user->notify(new KitchenOrderNotification($restaurantOrder, $staff->user, $roleService));
            }
        }

        return 'Order created successfully!';
    }


    public function getById($id)
    {
        $order = RestaurantOrder::find($id);
        if (empty($order)) {
            throw new ModelNotFoundException("Order not found");
        }
        return $order;
    }

    public function cancelOrder($order)
    {
        $order = $this->getById($order);
        $order->update(['status' => StatusConstants::CANCELLED]);
        return $order;
    }

    public function deleteOrder($order)
    {
        $order = $this->getById($order);
        $order->delete();
        return $order;
    }
}
