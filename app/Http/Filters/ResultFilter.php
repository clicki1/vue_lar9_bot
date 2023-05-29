<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class ResultFilter extends AbstractFilter
{
    public const COAST = 'coast';
    public const MESSAGE_IG = 'message_id';
    public const YEAR_RES = 'year_res';
    public const MONTH_RES = 'month_res';
    public const CATEGORY_IG = 'category_id';
    public const ERR_CAT = 'err_cat';

    protected function getCallbacks(): array
    {
        return [
            self::COAST => [$this, 'coast'],
            self::MESSAGE_IG => [$this, 'message_id'],
            self::YEAR_RES => [$this, 'year_res'],
            self::MONTH_RES => [$this, 'month_res'],
            self::CATEGORY_IG => [$this, 'category_id'],
            self::ERR_CAT => [$this, 'err_cat']
        ];
    }

    public function coast(Builder $builder, $value)
    {
        $builder->where('coast', 'like', "%{$value}%");
    }

    public function message_id(Builder $builder, $value)
    {
        $builder->where('message_id', '=', "$value");
    }
    public function year_res(Builder $builder, $value)
    {
        $builder->whereYear('created_at', '=', "$value");
    }
    public function month_res(Builder $builder, $value)
    {
        if(empty(self::YEAR_RES)){
            dd(111);
        }
        $builder->whereMonth('created_at', '=', "$value");
    }
    public function category_id(Builder $builder, $value)
    {
        $builder->where('category_id', '=', "$value");
    }
    public function err_cat(Builder $builder, $value)
    {
        $builder->where('category_id', '=', null);
    }
}
