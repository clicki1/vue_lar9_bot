<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class MessageFilter extends AbstractFilter
{
    public const MESSAGE = 'message';

    protected function getCallbacks(): array
    {
        return [
            self::MESSAGE => [$this, 'message'],
        ];
    }

    public function message(Builder $builder, $value)
    {
        $builder->where('message', 'like', "%{$value}%");
    }
}
