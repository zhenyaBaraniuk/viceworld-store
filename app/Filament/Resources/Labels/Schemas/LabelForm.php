<?php

namespace App\Filament\Resources\Labels\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class LabelForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->label(__('labels.name')),
            ]);
    }
}
