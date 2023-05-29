<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use HasFactory;
    use SoftDeletes;
    //подключаем наш фильтер
    use Filterable;

    protected $guarded = [];
    protected $table = 'tags';
    protected $with = ['category'];


    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
