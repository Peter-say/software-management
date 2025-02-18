<?php

namespace App\Http\Controllers\Dashboard\Hotel;

use App\Http\Controllers\Controller;
use App\Models\HotelSoftware\HotelPaymentPlatform;
use App\Models\HotelSoftware\PaymentPlatform;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PaymentPlatformController extends Controller
{
    public function validated(array $data)
    {
        $validator = Validator::make($data, [
            'selected_platform' => 'required|exists:payment_platforms,id',
            'public_key' => 'required|string|unique:hotel_payment_platforms,public_key',
            'secret_key' => 'required|string|unique:hotel_payment_platforms,secret_key',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        return $validator->validated();
    }
    public function store(Request $request)
    {
        try {
            $this->validated($request->all());
            HotelPaymentPlatform::create([
                'hotel_id' => User::getAuthenticatedUser()->hotel->id,
                'payment_platform_id' => $request->selected_platform,
                'public_key' => $request->public_key,
                'secret_key' => $request->secret_key,
            ]);
            return back()->with('success_message', 'App payment platform set up successfully');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            throw $e;
            return redirect()->back()->with('error_message', 'An error occurred while creating the modules.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $this->validated($request->all());
            $hotel = User::getAuthenticatedUser()->hotel;
            $payment_plaform = HotelPaymentPlatform::find($id)->where('hotel_id', $hotel->id);
            $payment_plaform->update([
                'hotel_id' => $hotel->id,
                'payment_platform_id' => $request->selected_platform,
                'public_key' => $request->public_key,
                'secret_key' => $request->secret_key,
            ]);
            return back()->with('success_message', 'App payment platform set up successfully');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            throw $e;
            return redirect()->back()->with('error_message', 'An error occurred while creating the modules.');
        }
    }
}
