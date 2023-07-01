<?php

namespace App\Models;

use App\Models\Traits\IsOwner;
use Illuminate\Database\Eloquent\Model;

class QuerySuggestionHistory extends Model
{
    use IsOwner;

    protected $fillable = [
        'key',
        'items',
        'user_id',
    ];

    protected $casts = [
        'items' => 'array',
    ];
}