<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;
    //подключаем наш фильтер
    use Filterable;


    protected $guarded = [];
    protected $table = 'categories';

    public function tags()
    {
        return $this->hasMany(Tag::class, 'category_id', 'id');
    }

}
