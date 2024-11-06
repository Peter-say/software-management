<?php

namespace App\hotelSoftwareModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'supplier_id','category_id','description','amount',
        'expense_date','qty','rate','note','hotel_id'
    ];
    public function supplier(){
        return $this->belongsTo('App\Models\Supplier');
    }
    public function payments(){
        return $this->hasMany('App\Models\ExpensePayment');
    }
    public function category(){
        return $this->belongsTo('App\Models\ExpenseCategory','category_id');
    }
    public function items(){
        return $this->hasMany('App\Models\ExpenseExpenseItem','expense_id');
    }
    // public function expenseItems(){
    //     return $this->hasMany('App\Models\ExpenseItem','expense_id');
    // }
    public function expenseItems()
    {
        return $this->belongsToMany(ExpenseItem::class, 'expense_expense_items', 'expense_id', 'expense_item_id')
            ->withPivot('qty', 'rate', 'amount', 'unit_qty');
    }
    
    public function getItems()
    {
        $itemsString = '';
        $itemNames = $this->items->map(function ($expenseItem) {
            return $expenseItem->expenseItem->name;
        })->toArray();

        $itemsString = implode(', ', $itemNames);
        return $itemsString;
    }
    public function paymentStatus(){
        $status = "Not Paid";
        if($this->payments()->sum('amount') >= $this->amount){
            $status = "All Paid"; 
        }
        if($this->payments()->sum('amount') < $this->amount  && $this->payments()->sum('amount') > 0){
            $status = "Part Paid"; 
        }
        return $status;
    }
}
