<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class TagFilter extends AbstractFilter
{
    public const TITLE = 'title';
    public const CATEGORY_IG = 'category_id';

    protected function getCallbacks(): array
    {
        return [
            self::TITLE => [$this, 'title'],
            self::CATEGORY_IG => [$this, 'category_id']
        ];
    }

    public function title(Builder $builder, $value)
    {
        $builder->where('title', 'like', "%{$value}%");
    }

    public function category_id(Builder $builder, $value)
    {
        $builder->where('category_id', '=', "$value");
    }
}
