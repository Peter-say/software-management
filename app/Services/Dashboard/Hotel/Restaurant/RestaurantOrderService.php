<?php

namespace App\Services\Dashboard\Hotel\Restaurant;

use App\Constants\StatusConstants;
use App\Models\HotelSoftware\RestaurantOrder;
use App\Models\HotelSoftware\RestaurantOrderItem;
use App\Models\HotelSoftware\WalkInCustomer;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class RestaurantOrderService
{
    public function validatedData(array $data)
    {
        // dd($data);
        $validator = Validator::make($data, [
            'outlet_id' => 'required|exists:outlets,id',
            'quantity' => 'required|numeric|min:1',
            'items' => 'required|array',
            'items.*.id' => 'required|exists:restaurant_items,id',
            'items.*.quantity' => 'required|numeric|min:1',

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
        $data = $this->validatedData($request->all());
        $user = User::getAuthenticatedUser();
        $data['user_id'] = $user->id;
        $data['hotel_id'] = $user->hotel->id;
        $data['order_date'] = Carbon::today();

        // Ensure 'amount' is set correctly from request
        $data['amount'] = $request->totalPrice; // or wherever you're getting the price from

        // Set the guest or create a walk-in customer
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

        // Set generic tax details
        $data['tax_rate'] = 2; // Assume a fixed tax rate for simplicity
        $data['tax_amount'] = $data['amount'] * ($data['tax_rate'] / 100); // Calculate based on amount
        $data['discount_rate'] = 0;
        $data['discount_type'] = 'Loyalty Discounts';
        $data['discount_amount'] = 0.00;
        $data['total_amount'] = $data['quantity'] * $data['amount'] + $data['tax_amount'];

        // Create the restaurant order
        $restaurantOrder = RestaurantOrder::create($data);
        if ($restaurantOrder) {
            $restaurantOrder->update(['status' => StatusConstants::OPENED]);
        }

        // Initialize total amount
        $totalAmount = 0;

        foreach ($data['items'] as $item) {
            $itemData = RestaurantOrderItem::create([
                'restaurant_order_id' => $restaurantOrder->id,
                'restaurant_item_id' => $item['id'], // Correctly accessing the item ID
                'qty' => $item['quantity'],
                'amount' => $item['quantity'] * $data['amount'], // Ensure amount is correctly referenced
                'tax_rate' => $data['tax_rate'],
                'tax_amount' => ($item['quantity'] * $data['amount']) * ($data['tax_rate'] / 100),
                'discount_rate' => $data['discount_rate'],
                'discount_type' => $data['discount_type'],
                'discount_amount' => 0, // Adjust this logic as necessary
                'total_amount' => ($item['quantity'] * $data['amount']) + ($item['quantity'] * $data['amount'] * ($data['tax_rate'] / 100)),
            ]);
            $totalAmount += $itemData->total_amount;
        }

        // Update total amount in the order
        $restaurantOrder->total_amount = $totalAmount + $data['tax_amount'] - $data['discount_amount'];
        $restaurantOrder->save();

        return 'Order created successfully!';
    }
}
