<?php

namespace App\Models\HotelSoftware;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'hotel_id','name','expense_category_id'
    ];
    public function expenseCategory(){
        return $this->belongsTo(ExpenseCategory::class);
    }
    public function expenseExpenseItem(){
        return $this->hasMany(ExpenseExpenseItem::class);
    }
    public function expense(){
        return $this->belongsToMany(Expense::class);
    }
    public function expenses()
    {
        return $this->belongsToMany(Expense::class, 'expense_expense_items', 'expense_item_id', 'expense_id')
            ->withPivot('qty', 'rate', 'amount', 'unit_qty');
    }
    
}
