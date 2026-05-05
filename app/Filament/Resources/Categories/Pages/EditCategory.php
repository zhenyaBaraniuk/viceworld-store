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
        ])->save();
    }

    protected function afterFill(): void
    {
        $media = $this->record->mediaFiles()
            ->wherePivot('collection', 'main_image')
            ->first();

        $this->data['main_image'] = $media?->id;
    }

    protected function getMediaCollections(): array
    {
        return [
            'main_image' => false,
        ];
    }
}
