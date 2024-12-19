<?php

namespace App\Models\HotelSoftware;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Supplier extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['hotel_id','name','contact_person_name','contact_person_phone',
    'bank_account_name','bank_name','bank_sort_code','bank_account_no','email', 'address'];

    public function expenses(){
        return $this->hasMany('App\Models\Expense');
    }
    
    public function getBalance(){
        //get total total_expenses_amount - total_payments
        $balance = $this->getTotalExpensesAmount() - $this->getTotalPaymentsAmount();
        return $balance;
    }   

    public function getTotalExpensesAmount(){
        $amount = Expense::where('supplier_id', $this->id)->sum('amount');
        return $amount;
    }

    public function getTotalPaymentsAmount(){
        $amount = ExpensePayment::join('expenses', 'expenses.id', '=', 'expense_payments.expense_id')
        ->where('expenses.supplier_id', $this->id)
        ->select('expense_payments.amount')->sum('expense_payments.amount');
        return $amount;
    }

    public function payments(){
        $payments = ExpensePayment::join('expenses', 'expenses.id', '=', 'expense_payments.expense_id')
        ->where('expenses.supplier_id',$this->id)
        ->select('expense_payments.*')
        ->orderBy('created_at', 'desc')->get();
        return $payments;
    }

    public function getSumOfNewBillsByMonth($month){
        //get all expenses related to supplier
        $sum = Expense::where('supplier_id', $this->id)
        ->whereMonth('expense_date','=',$month)->sum('amount');
        return $sum;
    }

    public function getTotalSupplyAmountByMonth($month,$year){
        $sum = Expense::where('supplier_id', $this->id)
        ->whereMonth('expense_date','=',$month)
        ->whereYear('expense_date','=',$year)->sum('amount');
        return $sum;
    }

    public function getAmountOwingBeforeAParticularMonth($month){
        //get all expenses with status not paid or paid part before the month and calculate the outstanding
        $paymentsAgainstTheExpenses = 0;
        $sumOfAllBillsForTheMonth = $this->getSumOfNewBillsByMonth($month);
        $expenses = Expense::where('supplier_id', $this->id)
        ->whereMonth('expense_date','<',$month)->get();
        
        foreach($expenses as $expense){
            //get payments
            foreach($expense->payments as $payment){
                $paymentsAgainstTheExpenses += $payment->amount;
            }
        }
        return $sumOfAllBillsForTheMonth - $paymentsAgainstTheExpenses;
    }

    public function getTotalOwingAsAtAParticularMonth($month){
        
        return ($this->getAmountOwingBeforeAParticularMonth($month) 
        + $this->getSumOfNewBillsByMonth($month)) - $this->getSumOfPaymentsMadeInAParticularMonth($month);
    }

    public function getSumOfPaymentsMadeInAParticularMonth($month){
        $payments = DB::table('expense_payments')->join('expenses', 'expenses.id', '=', 'expense_payments.expense_id')
        ->where('expenses.supplier_id', $this->id)
        ->whereMonth('expense_payments.date_of_payment','=',$month)
        ->select('expense_payments.amount')->distinct()->sum('expense_payments.amount');
        return $payments;
    }

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }
}
