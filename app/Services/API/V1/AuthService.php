<?php

namespace App\Services\API\V1;

use App\Helpers\ApiHelper;
use App\Mail\Api\ResetPasswordMail;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public static function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
        ]);

        $accessToken = $user->createToken('authToken');

        return response()->json(['user' => $user, 'access_token' => $accessToken->plainTextToken], 201);
    }

    public static function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($credentials)) {
            throw new AuthenticationException();
        }
        return Auth::user();
    }

    public static function logout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }


    public static function sendCode(Request $request)
    {
        return DB::transaction(function () use ($request) {
            $request->validate([
                'email' => 'required|email|exists:users,email',
            ]);

            $user = User::where('email', $request->email)->first();

            // Generate a unique 6-digit numeric code
            $resetCode = mt_rand(100000, 999999);

            // Calculate the expiration time (10 minutes from now)
            $expiration = Carbon::now()->addMinutes(10);

            $data =  [
                'email' => $request->email,
                'token' => $resetCode,
                'created_at' => Carbon::now(),
                'expires_at' => $expiration,
            ];

            DB::table('password_resets')->updateOrInsert(
                ['email' => $request->email],
                $data,
            );

            Mail::to($request->email)->send(new ResetPasswordMail($resetCode));
            return $data;
        });
    }


    public static function resetPassword(Request $request)
    {
        return DB::transaction(function () use ($request) {
            $request->validate([
                'code' => 'required|max:6|min:6|exists:password_resets,token',
                'password' => 'required|min:8|confirmed',
            ]);

            $resetRecord = DB::table('password_resets')
                ->where('token', $request->code)
                ->first();

            if (!$resetRecord) {
                return ApiHelper::errorResponse('Invalid input');
            }

            if (Carbon::now()->isAfter($resetRecord->expires_at)) {
                return ApiHelper::errorResponse('Reset code has expired');
            }

            $user = User::where('email', $resetRecord->email)->first();
            if (!$user) {
                throw new Exception('No code found on this email');
            }
            $user->password = Hash::make($request->password);
            $user->save();

            // Delete the reset code entry from the password_resets table
            DB::table('password_resets')
                ->where('token', $request->code)
                ->delete();
        });
    }
}
