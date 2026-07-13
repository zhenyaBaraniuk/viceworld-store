<?php

namespace App\Filament\Resources\Products\Pages;

use App\Filament\Resources\Products\ProductResource;
use App\Filament\Trait\SyncMedia;
use App\Models\Product;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

/**
 * @method Product getRecord()
 */
class EditProduct extends EditRecord
{
    use SyncMedia;

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

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $translation = $this->getRecord()->translate(app()->getLocale(), false);

        $media = $this->getRecord()->mediaFiles()
            ->whereIn('collection', ['images', 'main_image', 'video'])
            ->get()
            ->groupBy(fn ($image) => $image->pivot->collection);

        $video = $media->get('video')?->first();
        $data['video'] = $video
            ? ['id' => $video->id, 'url' => $video->url, 'mime_type' => $video->mime_type]
            : null;

        $mainImage = $media->get('main_image')?->first();
        $data['main_image'] = $mainImage
            ? ['id' => $mainImage->id, 'url' => $mainImage->url, 'mime_type' => $mainImage->mime_type]
            : null;

        $data['images'] = $media->get('images', collect())
            ->map(fn ($image) => ['id' => $image->id, 'url' => $image->url, 'mime_type' => $image->mime_type])
            ->toArray();

        $data['name'] = $translation?->name;
        $data['slug'] = $translation?->slug;
        $data['description'] = $translation?->description;

        return $data;
    }

    protected function afterSave(): void
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

    protected function getRedirectUrl(): ?string
    {
        return $this->getResource()::getUrl('edit', ['record' => $this->record]);
    }
}
