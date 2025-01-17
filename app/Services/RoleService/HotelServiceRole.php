<?php

namespace App\Services\RoleService;

use App\Models\HotelSoftware\HotelUser;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class HotelServiceRole
{
    public function userCanAccessSalesRole()
    {
        return ['Hotel_Owner', 'Manager', 'Sales'];
    }

    public function userCanAccessStoreRole()
    {
        return ['Hotel_Owner', 'Manager', 'Store'];
    }

    public function getHotelUserRoles()
    {
        $user =  User::getAuthenticatedUser();
        $roles = ['Hotel_Owner', 'Manager'];
        $hotelUser = HotelUser::where('user_id', $user->id)
            ->where('hotel_id', $user->hotel->id)->first();
            Log::info($user);
        if ($hotelUser) {
            if (in_array($hotelUser->role, $this->userCanAccessSalesRole())) {
                $roles[] = 'Sales';
            }
            if (in_array($hotelUser->role, $this->userCanAccessStoreRole())) {
                $roles[] = 'Store';
            }
        } else {
            abort(403, 'Unauthorized');
        }
        return array_unique( $roles);
    }
}
