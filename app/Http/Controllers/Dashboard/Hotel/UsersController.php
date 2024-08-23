<?php

namespace App\Http\Controllers\Dashboard\Hotel;

use App\Constants\AppConstants;
use App\Constants\StatusConstants;
use App\Http\Controllers\Controller;
use App\Models\hotelSoftware\Hotel;
use App\Models\HotelSoftware\HotelUser;
use App\Models\User;
use App\Services\Dashboard\Hotel\Users\RegistrationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class UsersController extends Controller
{

    protected $registration_service;

    public function __construct(RegistrationService $registration_service)
    {
        $this->registration_service = $registration_service;
    }

    public function overview()
    {

        $hotel = Hotel::where('uuid', User::getAuthenticatedUser()->hotel->uuid)->firstOrFail();
        $hotel_users = $hotel->hotelUser()->paginate(30);
        return view('dashboard.hotel.users.index', [
            'hotel_users' => $hotel_users
        ]);
    }

    public function create()
    {
        return view('dashboard.hotel.users.create', [
            'statusOptions' => StatusConstants::ACTIVE_OPTIONS,
            'roles' => AppConstants::ROLE_OPTIONS,
        ]);
    }


    public function store(Request $request)
    {
        $data = $request->all();
        try {
            $user = $this->registration_service->save($request, $data);
            return redirect()->route('dashboard.hotel-users.overview')->with('success_message', 'User created successfully and login details sent.');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // throw $e;
            return redirect()->back()->with('error_message', 'An error occurred while creating the user.');
        }
    }

     public function edit($id)
     {
         $hotel_user = HotelUser::findOrFail($id); // Fetch the user to edit
         return view('dashboard.hotel.users.create', [
             'statusOptions' => StatusConstants::ACTIVE_OPTIONS,
             'roles' => AppConstants::ROLE_OPTIONS,
             'hotel_user' => $hotel_user, 
         ]);
     }
 
     public function update(Request $request, $id)
     {
        // dd($request->all());
         $data = $request->all();
         try {
             $user = HotelUser::findOrFail($id); // Fetch the user to update
             $this->registration_service->save($request, $data, $user); // Pass the user to the save method
             return redirect()->route('dashboard.hotel-users.overview')->with('success_message', 'User updated successfully.');
         } catch (ValidationException $e) {
             return redirect()->back()->withErrors($e->errors())->withInput();
         } catch (\Exception $e) {
             return redirect()->back()->with('error_message', 'An error occurred while updating the user.' . $e->getMessage());
         }
     }

     public function delete(Request $request, $id)
     {
         try {
             $this->registration_service->delete($id);
             return redirect()->route('dashboard.hotel-users.overview')->with('success_message', 'User deleted successfully.');
         } catch (ValidationException $e) {
             return redirect()->back()->withErrors($e->errors())->withInput();
         } catch (\Exception $e) {
             return redirect()->back()->with('error_message', 'An error occurred while updating the user.' . $e->getMessage());
         }
     }
}
