<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
     protected $fillable = ['conversation_id', 'sender', 'content'];

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }
}
