<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Result extends Model
{
    use HasFactory;
    use SoftDeletes;
    //подключаем наш фильтер
    use Filterable;

    protected $guarded = [];
    protected $table = 'results';

    protected $with = ['category','message'];


    public function message()
    {
        return $this->belongsTo(Message::class);
    }

    public function chat()
    {
        return $this->belongsTo(Chat::class, 'chat_id', 'chat_id');
    }


    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
