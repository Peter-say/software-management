<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SeoAnalysis extends Model
{
    protected $fillable = [
        'uuid',
        'user_id',
        'title',
        'input_type',
        'url',
        'html_input',
        'prompt',
        'response',
    ];

    protected $casts = [
        'response' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'uuid'; // Optional: bind routes using UUID instead of ID
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
