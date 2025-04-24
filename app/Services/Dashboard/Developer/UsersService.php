<?php

namespace App\Services\Dashboard\Developer;

use App\Models\HotelSoftware\HotelUser;
use App\Models\User;

class UsersService
{
    public function getAllHotelAndRegularUsers()
    {
        $users_without_hotel = User::whereDoesntHave('hotelUser')->get()->map(function ($user) {
            return (object)[
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'address' => null,
                'hotel' => 'Regular User',
                'role' => $user->role,
                'phone' => null,
                'created_at' => $user->created_at,
                'photo' => $user->avatar
                ? getStorageUrl('hotel/users/photos/' . $user->avatar)
                : getStorageUrl('dashboard/images/gallery/hotel1.jpg'),
            ];
        });

        $users_with_hotels = HotelUser::with(['user', 'hotel'])->get()->map(function ($hotelUser) {
            return (object)[
                'id' => $hotelUser->user->id,
                'name' => $hotelUser->user->name,
                'email' => $hotelUser->user->email,
                'address' => $hotelUser->address,
                'hotel' => $hotelUser->hotel->name ?? 'Not Set',
                'role' => $hotelUser->role,
                'phone' => $hotelUser->phone,
                'created_at' => $hotelUser->user->created_at,
                'photo' => $hotelUser->photo
                ? getStorageUrl('hotel/users/photos/' . $hotelUser->photo)
                : getStorageUrl('dashboard/images/gallery/hotel1.jpg'),
            ];
        });

        return $users_without_hotel->merge($users_with_hotels);
    }
}