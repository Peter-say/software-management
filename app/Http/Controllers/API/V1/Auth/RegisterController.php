<?php

namespace App\Http\Controllers\API\V1\Auth;

use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;
use App\Services\API\V1\AuthService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        try {
            $data = AuthService::register($request);
            return ApiHelper::successResponse('User registered successfully', $data);
        } catch (ValidationException $e) {
            return ApiHelper::validationErrorResponse('Validation error', $e->errors());
        } catch (\Exception $e) {
            return ApiHelper::errorResponse('An error occurred while registering the user. Please try again later.', 500);
        }
    }
}
