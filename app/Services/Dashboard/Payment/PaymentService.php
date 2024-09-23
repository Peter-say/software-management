<?php

namespace App\Services\Dashboard\Payment;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentService
{

    protected function validatePayment(Request $request)
    {
        return $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'description' => 'nullable|string',
            'payment_method' => 'required|string',
        ]);
    }

    public function getById($id)
    {
        $payment = Payment::find($id);
        if (empty($payment)) {
            throw new ModelNotFoundException("Payment not found");
        }
        return $payment;
    }

    public function processPayment(Request $request, $payment_id = null)
    {
        return DB::transaction(function () use ($request, $payment_id) {
            $data = $this->validatePayment($request);
            $data['user_id'] = User::getAuthenticatedUser()->id;
            $data['payable_id'] = $request->input('payable_id');
            $data['payable_type'] = $request->input('payable_type');
            $data['transaction_id'] = 'TXN' . strtoupper(uniqid());
            $payment = Payment::create($data);

            $statusInfo = $this->evaluatePaymentStatus($payment->amount, $request->total_amount);
            $payment->status = $statusInfo['status'];
            $payment->save();

            return $payment;
        });
    }


    /**
     * Evaluate the payment status based on the paid amount and the requested amount.
     *
     * @param float $paidAmount
     * @param float $totalAmount
     * @return array
     */
    public function evaluatePaymentStatus($paidAmount, $totalAmount)
    {
        $status = 'not_paid';
        $color = 'danger'; // Default to red for not paid

        if ($paidAmount >= $totalAmount) {
            $status = 'completed';
            $color = 'success'; // Green for completed
        } elseif ($paidAmount > 0 && $paidAmount < $totalAmount) {
            $status = 'partial';
            $color = 'warning'; // Yellow for partially paid
        }
        return [
            'status' => $status,
            'color' => $color,
            'message' => ucfirst($status),
        ];
    }
}
