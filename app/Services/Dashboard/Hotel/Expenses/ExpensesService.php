<?php

namespace App\Services\Dashboard\Hotel\Expenses;

use App\Models\HotelSoftware\Expense;
use App\Models\HotelSoftware\ExpenseExpenseItem;
use App\Models\HotelSoftware\ExpenseItem;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ExpensesService
{
    public function validatedData($data)
    {
        $validator = Validator::make($data, [
            'expense_date' => 'required|date',
            'category_id' => 'required',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        return $validator->validated();
    }

    public function getById($id)
    {
        $expense = Expense::find($id);
        $expense->load('items');
        if (!$expense) {
            throw new ModelNotFoundException('Expense not found');
        }
        return $expense;
    }

    public function save(Request $request, $expense_id = null)
    {
        return DB::transaction(function () use ($request, $expense_id) {
            // Validate the request
            $validatedData = $this->validatedData($request->all());

            // Set the hotel_id for the expense
            $hotel_id = User::getAuthenticatedUser()->hotel->id;
            $data = $request->except(['description', 'qty', 'rate', 'unit_qty', 'amount']); // Remove amount from the main data

            // Calculate the total amount from the 'amount' array
            $totalAmount = array_sum($request->amount); // Sum up all the amounts

            // Add the total amount to the expense data
            $data['hotel_id'] = $hotel_id;
            $data['amount'] = $totalAmount; // Set the total amount
            $data['note'] = $request->note;
            // Check if an expense ID is provided for updating
            if ($expense_id) {
                // Find the existing Expense and update it
                $expense = $this->getById($expense_id);

                $expense->update($data);
            } else {
                // Create a new Expense entry if no expense ID is provided
                $expense = Expense::create($data);
            }

            // Loop through each item to create or update associated ExpenseExpenseItem records
            foreach ($request->description as $key => $description) {
                if ($description === null) {
                    continue; // Skip if the description is null
                }

                // Create or find the ExpenseItem for each description
                $item = ExpenseItem::firstOrCreate(
                    [
                        'expense_category_id' => $request->category_id,
                        'name' => $description, // Save description in 'name' field of ExpenseItem
                    ],
                    [
                        'hotel_id' => $hotel_id,
                    ]
                );

                // Create or update the associated ExpenseExpenseItem record
                $expenseExpenseItem = ExpenseExpenseItem::updateOrCreate(
                    [
                        'expense_id' => $expense->id,
                        'expense_item_id' => $item->id,
                        'hotel_id' => $hotel_id,
                    ],
                    [
                        'qty' => $request->qty[$key] ?? 1, // Default to 1 if qty is missing
                        'rate' => $request->rate[$key] ?? 0,
                        'amount' => $request->amount[$key] ?? 0,
                        'unit_qty' => $request->unit_qty[$key] ?? 1,
                    ]
                );
            }

            return $expense;
        });
    }
}
