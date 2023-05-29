<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'chats';


    public function results()
    {
        return $this->hasMany(Result::class, 'chat_id', 'chat_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'chat_id', 'chat_id');
    }
}
