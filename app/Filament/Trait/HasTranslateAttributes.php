<?php

namespace App\Filament\Trait;

/** @mixin \Astrotomic\Translatable\Translatable */
trait HasTranslateAttributes
{
    public function translated(string $attribute): ?string
    {
        return $this->translate(app()->getLocale(), true)?->getAttribute($attribute);
    }
}
