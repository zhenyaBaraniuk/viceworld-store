<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Relations\MorphPivot;

class Mediable extends MorphPivot
{
    use HasUlids;

    protected $table = 'mediables';

    public $timestamps = false;

    protected $fillable = [
        'collection',
        'order',
    ];
}
