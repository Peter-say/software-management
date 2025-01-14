<?php

namespace App\Services\RoleService;

use App\Models\HotelSoftware\HotelUser;
use Illuminate\Support\Facades\Auth;

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
        $user =  Auth::user();
        $roles = ['Hotel_Owner', 'Manager'];
        $hotelUser = HotelUser::where('user_id', $user->id)
            ->where('hotel_id', $user->hotel->id)->first();
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
