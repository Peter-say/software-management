<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
     protected $fillable = ['user_id', 'ai_type', 'title'];

    public function chats()
    {
        return $this->hasMany(Chat::class);
    }
}
