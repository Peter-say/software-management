<?php

namespace App\Services\Dashboard;

use App\Constants\AppConstants;
use App\Helpers\FileHelpers;
use App\Models\HotelSoftware\Hotel;
use App\Models\HotelSoftware\HotelUser;
use App\Models\SoftwareType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str; 

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
        $data['created_by'] = User::getAuthenticatedUser()->id;
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
        $data['uuid'] = Str::uuid(); 
        $data['user_id'] =User::getAuthenticatedUser()->id; // Assign the authenticated user's ID

        $hotel = Hotel::create($data);

        HotelUser::create([
            'user_id' =>User::getAuthenticatedUser()->id,
            'hotel_id' => $hotel->id, // The newly created hotel ID
            'role' => AppConstants::HOTEL_OWNER,
            'user_account_id' =>User::getAuthenticatedUser()->id, // The user who is performing this onboarding action for the hotel
        ]);

        return $hotel;
    }
}
