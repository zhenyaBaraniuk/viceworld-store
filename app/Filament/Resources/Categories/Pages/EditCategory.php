<?php

namespace App\Filament\Resources\Categories\Pages;

use App\Filament\Resources\Categories\CategoryResource;
use App\Filament\Trait\SyncMedia;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Validation\ValidationException;

class EditCategory extends EditRecord
{
    use SyncMedia;

    protected static string $resource = CategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function beforeValidate(): void
    {
        $parentId = $this->data['parent_id'] ?? null;

        if (! $parentId) {
            return;
        }

        if ($parentId === $this->record->id) {
            throw ValidationException::withMessages([
                'data.parent_id' => 'Parent cannot be the category itself',
            ]);
        }

        if (in_array($parentId, $this->record->getDescendantIds())) {
            throw ValidationException::withMessages([
                'data.parent_id' => 'Descendant cannot assign as parent',
            ]);
        }
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $translation = $this->record->translate(app()->getLocale(), false);

        $mainImage = $this->record->mediaFiles()
            ->wherePivot('collection', 'main_image')
            ->first();

        $data['main_image'] = $mainImage
            ? ['id' => $mainImage->id, 'url' => $mainImage->url, 'mime_type' => $mainImage->mime_type]
            : null;

        $data['name'] = $translation?->name;
        $data['slug'] = $translation?->slug;
        $data['description'] = $translation?->description;

        return $data;
    }

    protected function afterSave(): void
    {
        $this->syncMedia();

        $this->record->translateOrNew(app()->getLocale())->fill([
            'name' => $this->data['name'],
            'slug' => $this->data['slug'],
            'description' => $this->data['description'],
        ])->save();
    }

    protected function getMediaCollections(): array
    {
        return CategoryResource::mediaCollections();
    }
}
