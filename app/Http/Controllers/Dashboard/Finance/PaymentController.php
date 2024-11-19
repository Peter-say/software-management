<?php

namespace App\Http\Controllers\Dashboard\Finance;

use App\Http\Controllers\Controller;
use App\Services\Dashboard\Finance\Payment\PaymentService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    protected $payment_service;
    public function __construct(PaymentService $payment_service)
    {
        $this->payment_service = $payment_service;
    }
    public function payWithCard(Request $request)
    {
        try {
            $this->payment_service->processPayment($request);
            return back()->with('success_message', "Payment made successfully");
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->withInput($request->all())
                ->with('error_message', 'The specified resource was not found.');
        } catch (Exception $e) {
            return redirect()->back()->withInput($request->all())->with('error_message', $e->getMessage());
        } catch (\Throwable $th) {
            Log::info($th);
            throw $th;
            return back()->with('error_message', 'An error occurred while submitting your request. Please try again.');
        }
    }
}
