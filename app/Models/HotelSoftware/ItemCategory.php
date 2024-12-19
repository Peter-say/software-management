<?php

namespace App\Models\HotelSoftware;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemCategory extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function purchase()
    {
        return $this->hasMany(Purchase::class);
    }
}
