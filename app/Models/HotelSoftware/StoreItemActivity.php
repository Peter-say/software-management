<?php

namespace App\Models\HotelSoftware;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreItemActivity extends Model
{
    use HasFactory;
    protected $fillable = [
        'store_item_id',
        'qty',
        'store_id',
        'store_issue_id',
        'previous_qty',
        'activity_date',
        'current_qty',
        'description',
    ];
}
