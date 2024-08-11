<?php

namespace App\Services\Dashboard\Hotel\Users;

use App\Helpers\FileHelpers;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendUserLoginDetailsMail;
use App\Models\HotelSoftware\HotelUser;
use Illuminate\Http\Request;
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
        // Get the user ID from the request, if available
        $id = $request->input('id');
        
        // Validate data
        $validatedData = $this->validated($data, $id);
        
        // If an ID is provided, attempt to find the user for update
        $hotel_user = HotelUser::find($id);
        
        // If no user is found and an ID was provided, it’s an error
        if ($id && !$hotel_user) {
            throw new \Exception('User not found.');
        }
        
        if ($hotel_user) {
            // Update the existing user
            $hotel_user->user->update([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'] // Validate to avoid duplicates
            ]);
    
            $isNewUser = false;
        } else {
            // Create a new user
            $hotel_user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make(Str::random(12)), // Create a random password
            ]);
    
            $isNewUser = true;
        }
        
        // Handle file upload
        if ($request->hasFile('photo')) {
            $photoDirectory = 'hotel/users/photos';
            Storage::disk('public')->makeDirectory($photoDirectory);
            $photoPath = basename(FileHelpers::saveFileRequest($request->file('photo'), $photoDirectory));
            $validatedData['photo'] = $photoPath;
        }
        
        // Exclude unwanted fields
        $hotelUserData = $validatedData;
        unset($hotelUserData['name']);
        unset($hotelUserData['email']);
        unset($hotelUserData['password']);
        
        // Add required fields for HotelUser
        $hotelUserData['user_id'] = $hotel_user->id;
        $hotelUserData['hotel_id'] = auth()->user()->hotel->id;
        
        // Create or update the HotelUser
        HotelUser::updateOrCreate(
            ['user_id' => $hotel_user->id, 'hotel_id' => auth()->user()->hotel->id],
            $hotelUserData
        );
        
        // Send login details if this is a new user
        if ($isNewUser) {
            $this->sendLoginDetails($hotel_user->id);
        }
        
        return $hotel_user;
    }
    
    
    



    // Send login details to the user
    public function sendLoginDetails($hotel_userId)
    {
        try {
            $hotel_user = User::findOrFail($hotel_userId);

            // Generate a random password
            $randomPassword = Str::random(12);
            $hotel_user->password = Hash::make($randomPassword);
            $hotel_user->save();

            // Send login details email
            Mail::to($hotel_user->email)->send(new SendUserLoginDetailsMail($hotel_user, $randomPassword));

            return $hotel_user->toArray();
        } catch (\Exception $e) {
            // Handle exception
            return ['error_message' => 'An error occurred while updating the user.'];
        }
    }
}
