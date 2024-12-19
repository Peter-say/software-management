<?php

namespace App\Models\HotelSoftware;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreIssueStoreItem extends Model
{
    use HasFactory;
    protected $fillable = ['store_id','store_issue_id','store_item_id','qty'];
}
