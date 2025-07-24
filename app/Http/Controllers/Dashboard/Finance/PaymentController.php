<?php

namespace App\Http\Controllers\Dashboard\Finance;

use App\Http\Controllers\Controller;
use App\Models\HotelSoftware\RoomReservation;
use App\Services\Dashboard\Finance\Payment\PaymentService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class PaymentController extends Controller
{
    protected $payment_service;
    public function __construct(PaymentService $payment_service)
    {
        $this->payment_service = $payment_service;
    }

    public function list()
    {
        $request = request();
        $payments = $this->payment_service->list($request);
        $totalAmount = $payments->sum('amount');

        if ($request->ajax()) {
            $html = view('dashboard.hotel.finance.payment.search', compact('payments', 'totalAmount'))->render();
            $formattedAmount = '₦' . number_format($totalAmount, 2);

            return response()->json([
                'html' => $html,
                'totalAmount' => "<strong>Total Amount:</strong> $formattedAmount"
            ]);
        }

        return view('dashboard.hotel.finance.payment.list', compact('payments', 'totalAmount'));
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
        try {

            $this->payment_service->processPayment($request);
            return response()->json([
                'success' => true,
                'message' => "Payment made successfully.",
            ]);
            return response()->json(['success' => false, 'message' => "Payment made successfully."], 400);
        } catch (ValidationException $e) {
            return response()->json(['success' => false, 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            throw $e;
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating the reservation.',
            ]);
        }
    }
}
