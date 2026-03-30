<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class СategoryTranslation extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'locale',
    ];
}
