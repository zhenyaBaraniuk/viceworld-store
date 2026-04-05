<?php

namespace App\Filament\Resources\Products\Pages;

use App\Filament\Resources\Products\ProductResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Product edited';
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function afterEdit(): void
    {
        $this->record->translateOrNew(app()->getLocale())->fill([
            'name' => $this->data['name'],
            'slug' => $this->data['slug'],
            'description' => $this->data['description'],
        ])->save();
    }
}
