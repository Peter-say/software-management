<?php

namespace App\Services\Dashboard\Hotel\Outlet;

use App\Models\HotelSoftware\Outlet;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class OutletService
{
    public function validated(array $data)
    {
        // Merge input fields to prioritize the appropriate name
        $data['name'] = $data['name'] ?? $data['outlet_name'] ?? null;
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'type' => 'required',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        return $validator->validated();
    }

    public function save(Request $request)
    {
        // Validate the incoming data
        $validatedData = $this->validated($request->all());

        if (isset($data['outlet_id'])) {
            $validatedData['outlet_id'] = $data['outlet_id'];
        }

        // Check if this is an update or create request
        if (isset($validatedData['outlet_id'])) {
            // Update existing room
            $outlet = Outlet::find($validatedData['outlet_id']);
            if (!$outlet) {
                throw new Exception('Outlet not found');
            }
            $outlet->update($validatedData);
        } else {
            // Create a new room
            $validatedData['hotel_id'] = User::getAuthenticatedUser()->hotel->id;
            $outlet = Outlet::create($validatedData);
        }

        return $outlet;
    }
}
