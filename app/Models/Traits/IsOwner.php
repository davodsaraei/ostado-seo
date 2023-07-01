<?php

namespace App\Models\Traits;

use App\Models\User;
use App\Models\Traits\ConditionalWhere;
use Illuminate\Database\Eloquent\Builder;

trait IsOwner
{
    use ConditionalWhere;

    public function user()
    {
        return $this->belongsTo(User::class, $this->userColumn());
    }

    public function scopeWhereOwn(Builder $query, $user_id = false)
    {
        $user_id = $user_id ?: auth()->user()->id;

        $query->where($this->userColumn(), $user_id);

        return $query;
    }

    public function scopeOrWhereOwn(Builder $query, $user_id = false)
    {
        $user_id = $user_id ?: auth()->user()->id;

        $query->orWhere($this->userColumn(), $user_id);

        return $query;
    }

    public function scopeWhereIfOwn(Builder $query, $condition, $user_id = false)
    {
        $user_id = $user_id ?: auth()->user()->id;

        $query->whereIf(
            $condition, fn ($q) => $q->where($this->userColumn(), $user_id)
        );

        return $query;
    }

    public function userColumn()
    {
        return property_exists($this, 'user_column') ? $this->user_column : 'user_id';
    }
}
