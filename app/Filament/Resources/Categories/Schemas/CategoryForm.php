<?php

namespace App\Filament\Resources\Categories\Schemas;

use App\Enums\GenderLine;
use App\Filament\Forms\Components\MediaPicker;
use App\Models\Category;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state)))
                    ->required()
                    ->maxLength(255),

                TextInput::make('slug'),

                RichEditor::make('description')
                    ->disableToolbarButtons([
                        'blockquote',
                        'codeBlock',
                        'table',
                        'attachFiles',
                        'subscript',
                        'superscript',
                    ])
                    ->columnSpanFull(),

                MediaPicker::make('main_image')
                    ->hiddenLabel()
                    ->columnSpanFull()
                    ->collection('main_image'),

                Select::make('parent_id')
                    ->label('Category')
                    ->options(fn () => Category::with('translations')
                        ->get()
                        ->pluck('name', 'id'))
                    ->searchable()
                    ->getSearchResultsUsing(function (string $search): array {
                        return Category::query()->whereHas('translations', fn ($q) => $q->where('name', 'like', "%{$search}%"))->limit(50)->get()->mapWithKeys(
                            fn ($category) => [$category->id => $category->translate(app()->getLocale(), true)?->name]
                        )->toArray();
                    })
                    ->getOptionLabelUsing(fn (string $value): ?string => Category::query()->find($value)?->translate(app()->getLocale(), true)?->name),

                Select::make('gender_line')
                    ->options(GenderLine::class)
                    ->required(),

                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
