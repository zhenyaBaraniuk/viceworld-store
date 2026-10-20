<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class LabelTranslation extends Model
{
    use HasUlids;

    public $timestamps = false;

    protected $fillable = [
        'name',
    ];
}
