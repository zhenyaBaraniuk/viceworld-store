<?php

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\Field;

class MediaPicker extends Field
{
    protected(set) bool $isMultiple = false;

    protected(set) string $collection = '';

    protected string $view = 'filament.forms.components.media-picker';

    public function multiple(bool $condition = true): static
    {
        $this->isMultiple = $condition;

        return $this;
    }

    public function collection(string $collection): static
    {
        $this->collection = $collection;

        return $this;
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->default(fn() => $this->isMultiple ? [] : null);
    }
}
