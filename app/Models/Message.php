<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use HasFactory;
    use SoftDeletes;
    //подключаем наш фильтер
    use Filterable;

    protected $guarded = [];
    protected $table = 'messages';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
//
//    public function result()
//    {
//        return $this->hasOne(Result::class);
//    }

    public function chat()
    {
        return $this->belongsTo(Chat::class, 'chat_id', 'chat_id');
    }

    public function results()
    {
        return $this->hasMany(Result::class, 'message_id', 'id');
    }

}
