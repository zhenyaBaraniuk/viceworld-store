<?php

namespace App\Filament\Resources\Products\Pages;

use App\Filament\Resources\Products\ProductResource;
use App\Filament\Trait\SyncMedia;
use App\Models\Product;
use Filament\Resources\Pages\CreateRecord;

/**
 * @method Product getRecord()
 */
class CreateProduct extends CreateRecord
{
    use SyncMedia;

    protected static string $resource = ProductResource::class;

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Product created';
    }

    protected function afterCreate(): void
    {
        $this->syncMedia();

        $this->getRecord()->translateOrNew(app()->getLocale())->fill([
            'name' => $this->data['name'],
            'slug' => $this->data['slug'],
            'description' => $this->data['description'],
        ])->save();
    }

    protected function getMediaCollections(): array
    {
        return ProductResource::mediaCollections();
    }
}
