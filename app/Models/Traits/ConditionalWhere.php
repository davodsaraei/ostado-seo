<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

trait ConditionalWhere
{
    /**
     * If condition be valid add where
     *
     * @param Builder $query
     * @param bool $condition
     * @param mixed $where
     *
     * @return Builder
     */

    public function scopeWhereIf(Builder $query, $condition, ...$where)
    {
        return $condition ? $query->where(...$where) : $query;
    }
}
