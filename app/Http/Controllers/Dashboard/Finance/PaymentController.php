<?php

namespace App\Http\Controllers\Dashboard\Finance;

use App\Http\Controllers\Controller;
use App\Models\HotelSoftware\RoomReservation;
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

    public function pay()
    {
        $request = request();
        $reservation_id = $request->query('reservation_id');
        $bar_order_id = $request->query('bar_order_id');
        $restaurant_order_id = $request->query('restaurant_order_id');
        $reservation = RoomReservation::find($reservation_id);
        if (!$reservation) {
            return redirect()->route('dashboard.hotel.reservations.index')->with('error_messag', 'Reservation not found');
        }
        return view('dashboard.general.payment.create', [
            'reservation' => $reservation,
            'bar_order_id' => $bar_order_id,
            'restaurant_order_id' => $restaurant_order_id,
        ]);
    }


    public function initiatePayment(Request $request)
    {
        dd($request->all());
        try {
            $this->payment_service->processPayment($request);
            return back()->with('success_message', "Payment made successfully");
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->withInput($request->all())
                ->with('error_message', 'The specified resource was not found.');
        } catch (Exception $e) {
            return redirect()->back()->withInput($request->all())->with('error_message', $e->getMessage());
            throw $th;
        } catch (\Throwable $th) {
            Log::info($th);
            throw $th;
            return back()->with('error_message', 'An error occurred while submitting your request. Please try again.');
        }
    }

    public function list()
    {
        $request = request();
        $payments = $this->payment_service->list($request);
        return view('dashboard.finance.payment.index', [
            'payments' => $payments,
        ]);
    }
}
