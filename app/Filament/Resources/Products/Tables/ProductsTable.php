<?php

namespace App\Filament\Resources\Products\Tables;

use App\Enums\GenderLine;
use App\Enums\Product\ProductStatus;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Name')
                    ->getStateUsing(fn ($record) => $record->getTranslatedAttribute('name'))
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->whereHas('translations', fn ($q) => $q->where('name', 'like', "%{$search}%"));
                    }),

                TextColumn::make('slug')
                    ->label('Slug')
                    ->getStateUsing(fn ($record) => $record->getTranslatedAttribute('slug'))
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->whereHas('translations', fn ($q) => $q->where('slug', 'like', "%{$search}%"));
                    }),

                SpatieMediaLibraryImageColumn::make('main_image')
                    ->collection('main_image')
                    ->imageHeight('40')
                    ->square(),

                TextColumn::make('category.name')
                    ->label('Category')
                    ->getStateUsing(fn ($record) => $record->category?->getTranslatedAttribute('name'))
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->whereHas('translations', fn ($q) => $q->where('name', 'like', "%{$search}%"));
                    }),

                TextColumn::make('price')
                    ->money()
                    ->sortable(),

                TextColumn::make('status')
                    ->badge()
                    ->searchable(),

                TextColumn::make('gender_line')
                    ->badge()
                    ->searchable(),

                IconColumn::make('is_featured')
                    ->boolean(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(ProductStatus::class)
                    ->multiple(),

                SelectFilter::make('gender_line')
                    ->options(GenderLine::class)
                    ->multiple(),

                TernaryFilter::make('is_featured'),
            ])
            ->defaultSort('created_at', 'desc')
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
