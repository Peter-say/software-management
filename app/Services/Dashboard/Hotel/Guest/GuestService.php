<?php

namespace App\Services\Dashboard\Hotel\Guest;

use App\Constants\AppConstants;
use App\Helpers\FileHelpers;
use App\Models\HotelSoftware\Guest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;


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
            'id_picture_location' => 'nullable|image|max:2024',
            'birthday' => 'nullable',
            'address' => 'nullable|string|max:255',
            'state_id' => 'nullable|exists:states,id',
            'country_id' => 'nullable|exists:countries,id',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $validator->validated();
    }

    public function getById($id)
    {
        $guest = Guest::find($id);
        if (empty($guest)) {
            throw new ModelNotFoundException("Guest not found");
        }
        return $guest;
    }


    public function saveGuest(Request $request, $guest_id = null)
    {
        // Validate the data (passing request data as an array)
        $validatedData = $this->validatedData($request->all(), $guest_id);

        // Assign hotel ID to the guest data    
        $hotel = User::getAuthenticatedUser()->hotel->id;
        $validatedData['hotel_id'] = $hotel;
        $validatedData['uuid'] = Str::uuid();

        // Handle birthday date conversion if present
        if (isset($validatedData['birthday'])) {
            $validatedData['birthday'] = Carbon::createFromFormat('d F, Y', $validatedData['birthday'])->format('Y-m-d');
        }

        // Handle ID picture upload
        if ($request->hasFile('id_picture_location')) {
            $imageDirectory = 'hotel/guest/id';
            Storage::disk('public')->makeDirectory($imageDirectory);
            $imagePath = basename(FileHelpers::saveImageRequest($request->file('id_picture_location'), $imageDirectory));
            $validatedData['id_picture_location'] = $imagePath;
        }

        // Check for existing guest excluding the current guest ID
        $existingGuest = Guest::where('first_name', $validatedData['first_name'])
            ->where('last_name', $validatedData['last_name'])
            ->where('phone', $validatedData['phone'])
            ->where('email', $validatedData['email'])
            ->where('hotel_id', $hotel)
            ->when($guest_id, function ($query) use ($guest_id) {
                return $query->where('id', '!=', $guest_id); // Omit current guest ID
            })
            ->first();

        if ($existingGuest) {
            // Return or throw an exception
            throw ValidationException::withMessages([
                'error_message' => 'Guest with the same details already exists.'
            ]);
        }
        // Check if we're updating an existing guest or creating a new one
        if ($guest_id) {
            // Update existing guest
            $guest = Guest::findOrFail($guest_id);
            if (empty($guest->uuid)) {
                $validatedData['uuid'] = Str::uuid();
            }
            $guest->update($validatedData);
        } else {
            // Create new guest
            $guest = Guest::create($validatedData);
        }

        // Return the guest object
        return $guest;
    }

    public static function list(array $data = [])
    {
        $builder = Guest::latest();
        // Check if the user is an admin
        if (User::getAuthenticatedUser()->role === AppConstants::ADMIN) {
            // Admin can see all guests, no need to filter by hotel_id
            return $builder;
        }
        // If the user is not an admin, restrict guests by hotel_id
        $hotelId = User::getAuthenticatedUser()->hotel->id;
        // Optionally allow overriding of the hotel_id from the $data array
        if (!empty($data['hotel_id'])) {
            $hotelId = $data['hotel_id'];
        }
        // Filter by the determined hotel ID
        $builder = $builder->where("hotel_id", $hotelId);
        return $builder;
    }

    public function delete($id)
    {
        $guest = $this->getById($id);
        $guest->delete();
    }

    
}
    