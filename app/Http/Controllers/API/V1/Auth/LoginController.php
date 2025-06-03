<?php

namespace App\Http\Controllers\API\V1\Auth;

use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;
use App\Services\API\V1\AuthService;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        try {
            $user = AuthService::login($request); // Handles validation & authentication
            $accessToken = $user->createToken('authToken')->plainTextToken;

            return ApiHelper::successResponse('User logged in successfully', [
                'user' => $user,
                'access_token' => $accessToken,
            ]);
        } catch (ValidationException $e) {
            return ApiHelper::validationErrorResponse($e);
        } catch (AuthenticationException $e) {
            return ApiHelper::errorResponse('Login attempt failed. Invalid credentials.', 401);
        }
    }

    public function logout(Request $request)
    {
        try {
            $user = AuthService::logout($request);
            return ApiHelper::successResponse('User logged out successfully', 200);
        } catch (ValidationException $e) {
            return ApiHelper::validationErrorResponse($e);
        } catch (AuthenticationException $e) {
            return ApiHelper::errorResponse('Something wnt wrong.', 401);
        }
    }
}
