<?php

namespace App\Services\Dashboard\Hotel\Guest;

use App\Helpers\FileHelpers;
use App\Models\HotelSoftware\Guest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;


class GuestService
{
    public function validatedData($data, $guest_id = null)
    {

        $validator = Validator::make($data, [
            'title' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'other_names' => 'nullable|string|max:255',
            'email' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('guests')->ignore($guest_id),
            ],
            'phone_code' => 'nullable|string|max:10',
            'phone' => [
                'nullable',
                'string',
                'max:20',
                Rule::unique('guests')->ignore($guest_id),
            ],
            'other_phone' => 'nullable|string|max:20',
            'id_picture_location' => 'nullable|string|max:255',
            'birthday' => 'nullable|date|before:today',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $validator->validated();
    }


    public function saveGuest(Request $request, $data, $guest_id = null)
    {
        // Validate the data
        $validatedData = $this->validatedData($data);
    
        // Assign hotel ID to the guest data
        $hotel = User::getAuthenticatedUser()->hotel->id;
        $validatedData['hotel_id'] = $hotel;

        // Handle ID picture upload
        if ($request->hasFile('id_picture_location')) {
            $imageDirectory = 'hotel/guest/id';
            Storage::disk('public')->makeDirectory($imageDirectory);
            $imagePath = basename(FileHelpers::saveFileRequest($request->file('id_picture_location'), $imageDirectory));
            $validatedData['id_picture_location'] = $imagePath;
        }

        // Check for existing guest
        $existingGuest = Guest::where('first_name', $validatedData['first_name'])
            ->where('last_name', $validatedData['last_name'])
            ->where('phone', $validatedData['phone'])
            ->where('email', $validatedData['email'])
            ->where('hotel_id', $hotel)
            ->first();

        if ($existingGuest) {
            // Return or throw an exception
            return response()->json([
                'error_message' => 'Guest with the same details already exists.'
            ], 400);
        }

        // Check if we're updating an existing guest or creating a new one
        if ($guest_id) {
            // Update existing guest
            $guest = Guest::findOrFail($guest_id);
            $guest->update($validatedData);
        } else {
            // Create new guest
            $guest = Guest::create($validatedData);
        }

        // Return the guest object
        return $guest;
    }
}
