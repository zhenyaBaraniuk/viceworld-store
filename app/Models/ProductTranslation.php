<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class ProductTranslation extends Model
{
    use HasUlids;

    protected $fillable = [
        'name',
        'slug',
        'description',
    ];
}
