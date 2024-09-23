<?php

namespace App\Services\Dashboard\Transaction;

use App\Models\Transaction;
use App\Services\Dashboard\Payment\PaymentService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionService
{
    protected $payment_service;
    public function __construct(PaymentService $payment_service)
    {
        $this->payment_service = $payment_service;
    }
    /**
     * Validate the transaction data.
     *
     * @param Request $request
     * @return array
     */
    protected function validateTransaction(Request $request)
    {
        return $request->validate([
            'amount' => 'required|numeric|min:0.01',
            // 'transaction_type' => 'required|string|in:credit,debit',
            'description' => 'nullable|string',
        ]);
    }

    /**
     * Retrieve a transaction by its ID.
     *
     * @param int $id
     * @return Transaction
     * @throws ModelNotFoundException
     */
    public function getById($id)
    {
        $transaction = Transaction::find($id);
        if (empty($transaction)) {
            throw new ModelNotFoundException("Transaction not found");
        }
        return $transaction;
    }

    /**
     * Process a new transaction.
     *
     * @param Request $request
     * @return Transaction
     */
    public function processTransaction(Request $request, $payment)
    {
            $data = $this->validateTransaction($request);
            $data['transaction_reference'] = self::generateTransactionCode($request);

            // Use the payment passed from the previous step
            $data['payment_id'] = $payment->id;

            // Create the transaction
            $transaction = Transaction::create($data);
            $transaction->status = 'completed';
            $transaction->save();

            return $transaction;

    }


    private function generateTransactionCode()
    {
        $prefix = 'TRN';
        do {
            $randomNumber = mt_rand(100000000, 999999999); // Generates a 9-digit random number
            $code = $prefix . '_' . strtoupper($randomNumber);
        } while (Transaction::where('transaction_reference', $code)->exists());

        return $code;
    }
}
