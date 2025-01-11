<?php

namespace App\Models;

use App\Models\HotelSoftware\Hotel;
use Illuminate\Database\Eloquent\Model;

class Requisition extends Model
{
    protected $fillable = [
        'user_id',
        'department',
        'status',
    ];

    public function items()
    {
        return $this->hasMany(RequisitionItem::class);
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
}
