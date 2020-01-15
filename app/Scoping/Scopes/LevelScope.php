<?php

namespace App\Scoping\Scopes;
use Illuminate\Database\Eloquent\Builder;
use  App\Scoping\Scopes\Scope;

class LevelScope implements Scope
{
    public function apply(Builder $builder, $value)
    {
       return $builder->where('level', $value);
    }
}
