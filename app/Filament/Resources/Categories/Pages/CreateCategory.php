<?php

namespace App\Filament\Resources\Categories\Pages;

use App\Filament\Resources\Categories\CategoryResource;
use App\Filament\Trait\SyncMedia;
use Filament\Resources\Pages\CreateRecord;

class CreateCategory extends CreateRecord
{
    use SyncMedia;

    protected static string $resource = CategoryResource::class;

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Category created';
    }

    protected function afterCreate(): void
    {
        $this->syncMedia();

        $this->record->translateOrNew(app()->getLocale())->fill([
            'name' => $this->data['name'],
            'slug' => $this->data['slug'],
        ])->save();
    }

    private function getMediaCollections(): array
    {
        return CategoryResource::mediaCollections();
    }
}
