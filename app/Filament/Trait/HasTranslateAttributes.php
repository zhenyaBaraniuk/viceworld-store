<?php

namespace App\Filament\Trait;

/** @mixin \Astrotomic\Translatable\Translatable */
trait HasTranslateAttributes
{
    public function getTranslatedAttribute(string $attribute): ?string
    {
        return $this->translate(app()->getLocale(), true)?->getAttribute($attribute);
    }
}
