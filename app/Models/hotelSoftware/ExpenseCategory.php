<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExpenseCategory extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name','parent_id','hotel_id'
    ];
    public function expenses()
    {
        return $this->hasMany('App\Models\Expense','category_id');
    }
    public function subCategories()
    {
        return $this->hasMany('App\Models\ExpenseCategory');
    }
    public function parentCategory()
    {
        return $this->belongsTo('App\Models\ExpenseCategory','parent_id');
    }
    public function expenseItem()
    {
        return $this->hasMany('App\Models\ExpenseItem','expense_category_id');
    }
}
