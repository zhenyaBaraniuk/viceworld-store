<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NpWarehouse extends Model
{
    protected $fillable = [
        'ref',
        'city_ref',
        'name',
        'number',
        'category',
        'postomat_type',
        'status',
    ];
}
