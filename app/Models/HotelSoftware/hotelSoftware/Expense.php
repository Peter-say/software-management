<?php

namespace App\Models\HotelSoftware;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'expense_date' => 'datetime',
    ];
    protected $fillable = [
        'supplier_id',
        'category_id',
        'amount',   
        'expense_date',
        'note',
        'hotel_id',
        'note',
        'description',
        'uploaded_file',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function category()
    {
        return $this->belongsTo(ExpenseCategory::class, 'category_id');
    }

    public function items()
    {
        return $this->hasMany(ExpenseExpenseItem::class, 'expense_id');
    }

    public function expenseItems()
    {
        return $this->belongsToMany(ExpenseItem::class, 'expense_expense_items', 'expense_id', 'expense_item_id')
            ->withPivot('qty', 'rate', 'amount', 'unit_qty');
    }

    public function getItems()
    {
        $itemsString = '';
        $itemNames = $this->expenseItems->map(function ($expenseItem) {
            return $expenseItem->name;
        })->toArray();

        $itemsString = implode(', ', $itemNames);
        return $itemsString;
    }

    public function payments()
    {
        return $this->morphMany(Payment::class, 'payable');
    }

    public function paymentStatus()
    {
        // Get the payments collection
        $payments = $this->payments()->get();

        // Calculate the total payment required from all related order items
        $totalPayment = $this->expenseItems()->sum('amount');

        // Check the payment status based on total payment and payments
        if ($payments->isEmpty()) {
            return 'pending';
        } elseif ($payments->sum('amount') < $totalPayment) {
            return 'partial';
        } else {
            return 'paid';
        }
    }

    public function item()
    {
        return $this->belongsTo(ExpenseExpenseItem::class);
    }
}
