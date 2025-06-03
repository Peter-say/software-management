<?php

namespace App\Http\Controllers\API\V1\Auth;

use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;
use App\Services\API\V1\AuthService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ForgetPasswordController extends Controller
{

    public function forgetPassword(Request $request)
    {
        try {
            $response = AuthService::sendCode($request);
            return $response;
          return ApiHelper::successResponse('Reset code sent to your email', $data);
        } catch (ValidationException $e) {
            return ApiHelper::errorResponse('Invalid email address', $e);
        } catch (ModelNotFoundException $e) {
            return ApiHelper::notFoundResponse('Email Address could not be found', $e);
        } catch (Exception $e) {
            return ApiHelper::errorResponse('Could not send reset code. Please try again', $e->getMessage());
        }
    }

    public function resetUserPassword(Request $request)
    {
        try {
            $response = AuthService::resetPassword($request);
            return $response;
        } catch (Exception $e) {
            return ApiHelper::errorResponse('Password reset process failed', $e->getMessage());
        }
    }
}