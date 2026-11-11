<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NpCity extends Model
{
    protected $fillable = [
        'ref',
        'name',
        'type_name',
        'area_ref',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
