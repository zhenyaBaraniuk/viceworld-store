<?php

namespace App\Models;

use App\Filament\Trait\HasTranslateAttributes;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class Attribute extends Model implements TranslatableContract
{
    use HasUlids, HasTranslateAttributes, Translatable;

    public $timestamps = false;

    public array $translatedAttributes = [
        'name',
    ];

    public function attributeValues(): HasMany
    {
        return $this->hasMany(AttributeValue::class);
    }
}
