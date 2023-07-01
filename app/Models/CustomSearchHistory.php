<?php

namespace App\Models;

use App\Models\Traits\IsOwner;
use Illuminate\Database\Eloquent\Model;

class CustomSearchHistory extends Model
{
    use IsOwner;

    protected $fillable = [
        'searched_item',
        'items',
    ];

    protected $casts = [
        'items' => 'array',
    ];
}