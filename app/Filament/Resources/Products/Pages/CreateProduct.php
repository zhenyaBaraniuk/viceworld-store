<?php

namespace App\Filament\Resources\Products\Pages;

use App\Filament\Resources\Products\ProductResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Product created';
    }

    protected function afterCreate(): void
    {
        $this->record->translateOrNew(app()->getLocale())->fill([
            'name' => $this->data['name'],
            'slug' => $this->data['slug'],
            'description' => $this->data['description'],
        ])->save();
    }
}
