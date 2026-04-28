<?php

namespace App\Filament\Resources\Products\Schemas;

use App\Filament\Forms\Components\MediaPicker;
use App\Models\Category;
use App\Enums\GenderLine;
use App\Enums\Product\ProductStatus;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Support\Str;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make()
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('name')
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn(Set $set, ?string $state) => $set('slug', Str::slug($state)))
                            ->required()
                            ->maxLength(255),

                        TextInput::make('slug'),

                        Select::make('category_id')
                            ->searchable()
                            ->getSearchResultsUsing(function (string $search): array {
                                return Category::whereHas('translations',
                                    fn($q) => $q->where('name', 'like', "%{$search}%")
                                )->limit(50)->get()->mapWithKeys(
                                    fn($category) => [$category->id => $category->translate(app()->getLocale(), true)?->name]
                                )->toArray();
                            })
                            ->getOptionLabelUsing(fn(string $value): ?string => Category::find($value)?->translate(app()->getLocale(), true)?->name)
                            ->required(),

                        TextInput::make('price')
                            ->required()
                            ->numeric()
                            ->prefix('$'),

                        Select::make('status')
                            ->options(ProductStatus::class)
                            ->required(),

                        Select::make('gender_line')
                            ->options(GenderLine::class)
                            ->required(),
                    ]),

                Tabs::make('Images')
                    ->tabs([
                        Tab::make('Головне фото')
                        ->schema([
                            MediaPicker::make('main_image')
                                ->hiddenLabel()
                                ->columnSpanFull()
                                ->collection('main_image'),
                        ]),
                        Tab::make('Додаткові фото')
                        ->schema([
                            MediaPicker::make('images')
                                ->hiddenLabel()
                                ->columnSpanFull()
                                ->collection('images')
                                ->multiple()
                        ]),
                    ]),

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

                Toggle::make('is_featured')
                    ->columnSpanFull()
                    ->required(),
            ]);
    }
}
