<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Attribute extends Model implements TranslatableContract
{
    use Translatable;

    public array $translatedAttributes = [
        'name',
    ];

    public function attributeValue(): HasMany
    {
        return $this->hasMany(AttributeValue::class);
    }
}
