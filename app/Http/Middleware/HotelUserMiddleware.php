<?php

namespace App\Http\Middleware;

use App\Models\HotelSoftware\HotelModulePreference;
use App\Models\HotelSoftware\HotelUser;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class HotelUserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        // $user = Auth::user();
        // $hotelUser = HotelUser::where('user_id', $user->id)->first();
        // $hasModules = false;

        // if ($hotelUser && $hotelUser->hotel) {
        //     $hasModules = HotelModulePreference::where('hotel_id', $hotelUser->hotel->id)->exists();
        // }

        // if (!$hasModules) {
        //     return redirect()->route('dashboard.hotel.module-preferences.create')->with('error_message', 'Please, select the modules your hotel would like to manage.');
        // }

        return $next($request);
    }
}
