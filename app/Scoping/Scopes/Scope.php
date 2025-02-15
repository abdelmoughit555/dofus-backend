<?php

namespace App\Scoping\Scopes;
use Illuminate\Database\Eloquent\Builder;

interface Scope
{
    public function apply(Builder $builder, $value);
}