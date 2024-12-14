<?php

namespace App\Models;
use App\Models\HotelSoftware\RoomType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Currency extends Model
{
    use SoftDeletes , SoftDeletes;
    public $table = "currencies";

    protected $fillable = [
        "name",
        "type",
        "short_name",
        "logo",
        "status",
    ];
    public function roomTypes()
{
    return $this->hasMany(RoomType::class, 'currency_id');
}

}