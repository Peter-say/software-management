<?php

namespace App\Models\HotelSoftware;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreIssue extends Model
{
    use HasFactory;
    protected $fillable = ['recipient_name','note','user_id','store_id','type','outlet_id'];
}
