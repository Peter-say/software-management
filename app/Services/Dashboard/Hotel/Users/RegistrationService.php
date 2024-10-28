<?php

namespace App\Services\Dashboard\Hotel\Users;

use App\Helpers\FileHelpers;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendUserLoginDetailsMail;
use App\Models\HotelSoftware\HotelUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RegistrationService
{
    protected $id;
    // Validate user data
    public function validated($data, $id = null)
    {
        $this->id = $id; // Assign the passed ID to the class property

        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($this->id), // Correctly use ignore to exclude the current user's email
            ],
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'role' => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $validator->validated();
    }





    // Store user and hotel user data
    public function save(Request $request, $data)
    {
        // Get the HotelUser ID from the request, if available
        $hotelUserId = $request->input('id');
    
        // Attempt to find the HotelUser by ID
        $hotelUser = HotelUser::find($hotelUserId);
    
        $auth_user = User::getAuthenticatedUser();
        // If a HotelUser is found, use the corresponding User ID for validation
        $userId = $hotelUser ? $hotelUser->user_id : null;
    
        // Validate data
        $validatedData = $this->validated($data, $userId);
        $oldPhotoPath = null;
    
        if ($hotelUser) {
            // Store the old photo path
            $oldPhotoPath = $hotelUser->photo;
    
            // Update the existing User
            $hotelUser->user->update([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
            ]);
    
            $isNewUser = false;
        } else {
            // Create a new User
            $randomPassword = Str::random(12);
            Log::info($randomPassword);
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($randomPassword), // Create a random password
            ]);
            // Exclude unwanted fields
            unset($validatedData['name'], $validatedData['email'], $validatedData['password']);
    
            // Add required fields for HotelUser
            $validatedData['hotel_id'] = $auth_user->hotel->id;
            $validatedData['user_id'] = $user->id;
            $validatedData['user_account_id'] = $auth_user->id;
    
            $isNewUser = true;
        }
    
        // Handle file upload
        if ($request->hasFile('photo')) {
            $photoDirectory = 'hotel/users/photos';
            Storage::disk('public')->makeDirectory($photoDirectory);
            $photoPath = basename(FileHelpers::saveImageRequest($request->file('photo'), $photoDirectory));
            $validatedData['photo'] = $photoPath;
    
            // Delete the old photo if it exists
            if ($oldPhotoPath) {
                FileHelpers::deleteFiles([$photoDirectory . '/' . $oldPhotoPath]);
            }
        }
    
        if ($hotelUser) {
            // Update the HotelUser with the new data
            $hotelUser->update($validatedData);
        } else {
            // Save HotelUser
            $hotelUser = HotelUser::create($validatedData);
        }
        // Send login details if this is a new user
        if ($isNewUser) {
            $this->sendLoginDetails($hotelUser->user_id);
        }
    
        return $hotelUser;
    }
    

    public function delete($hotelUserId)
    {
        try {
            // Find the HotelUser by ID
            $hotelUser = HotelUser::findOrFail($hotelUserId);

            // Get the associated User ID
            $userId = $hotelUser->user_id;

            // Delete the HotelUser record
            $hotelUser->delete();

            // Delete the associated User record
            $user = User::findOrFail($userId);
            $user->delete();

            return true;
        } catch (\Exception $e) {
            // Handle exception, log the error, or throw a custom exception
            throw new \Exception("An error occurred while deleting the user: " . $e->getMessage());
        }
    }





    // Send login details to the user
    public function sendLoginDetails($hotel_userId)
    {
        try {
            $hotel_user = User::findOrFail($hotel_userId);

            // Generate a random password
            $randomPassword = Str::random(12);
           Log::info( $randomPassword );
            $hotel_user->password = Hash::make($randomPassword);
            $hotel_user->save();

            // Send login details email
            Mail::to($hotel_user->email)->send(new SendUserLoginDetailsMail($hotel_user, $randomPassword));

            return $hotel_user->toArray();
        } catch (\Exception $e) {
            // Handle exception
            return ['error_message' => 'An error occurred while sending login details to user.'];
        }
    }
}
