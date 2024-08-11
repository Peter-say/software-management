<?php

namespace App\Services\Dashboard;

use App\Helpers\FileHelpers;
use App\Models\HotelSoftware\Hotel;
use App\Models\HotelSoftware\HotelUser;
use App\Models\SoftwareType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str; // Import Laravel's Str class for UUID

class Onboarding
{
    // In Onboarding.php

    public function validateSoftwareTypeInfo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'software_type' => 'required|string|max:255',
            'description' => 'required|string',
            'is_active' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return $validator->errors(); // Return errors, handle redirect in controller
        }

        return $validator->validated(); // Return validated data
    }

    public function validateHotelInfo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'hotel_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'state_id' => 'required|exists:states,id',
            'country_id' => 'required|exists:countries,id',
            'logo' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:2048',
            'website' => 'nullable|url',
        ]);

        if ($validator->fails()) {
            return $validator->errors(); // Return errors, handle redirect in controller
        }

        return $validator->validated(); // Return validated data
    }


    public function storeSoftwareTypeInfo(Request $request)
    {
        $data = $this->validateSoftwareTypeInfo($request);
        $data['created_by'] = auth()->user()->id;
        $software = SoftwareType::create($data);

        return $software;
    }

    public function saveHotelInfo(Request $request)
    {
        $data = $this->validateHotelInfo($request);

        // Handle file upload
        if ($request->hasFile('logo')) {
            $logoDirectory = 'hotel/logos';
            Storage::disk('public')->makeDirectory($logoDirectory);
            $logoPath = basename(FileHelpers::saveFileRequest($request->file('logo'), $logoDirectory));
            $data['logo'] = $logoPath;
        }

        // Generate UUID
        $data['uuid'] = Str::uuid(); // Using Laravel's Str class for UUID
        $data['user_id'] = auth()->user()->id; // Assign the authenticated user's ID

        $hotel = Hotel::create($data);

        HotelUser::create([
            'user_id' => auth()->user()->id,
            'hotel_id' => $hotel->id, // The newly created hotel ID
            'role' => 'Hotel_Owner',
            'user_account_id' => auth()->user()->id, // The user who is performing this onboarding action for the hotel
        ]);

        return $hotel;
    }
}
