<?php

namespace App\Http\Controllers\Dashboard\Developer;

use App\Http\Controllers\Controller;
use App\Models\HotelSoftware\HotelUser;
use App\Models\User;
use App\Services\Dashboard\Developer\UsersService;
use App\Services\Dashboard\Hotel\Users\RegistrationService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UsersController extends Controller
{
      protected $user_service;

    public function __construct(UsersService $user_service)
    {
        $this->user_service = $user_service;
    }
    public function index()
    {
        $users = User::all();
        return view('dashboard.developer.users.index', [
            'users' => $users,
        ]);
    }

     public function delete(Request $request, $id)
    {
        try {
            $this->user_service->delete($id);
            return redirect()->route('dashboard.hotel-users.overview')->with('success_message', 'User deleted successfully.');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error_message', 'An error occurred while deleting the user.' . $e->getMessage());
        }
    }
}
