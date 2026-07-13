<?php

namespace App\Filament\Resources\Attributes\Pages;

use App\Filament\Resources\Attributes\AttributeResource;
use App\Models\Attribute;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

/**
 * @method Attribute getRecord()
 */
class EditAttribute extends EditRecord
{
    protected static string $resource = AttributeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $translation = $this->getRecord()->translate(app()->getLocale());

        $data['name'] = $translation?->name;

        return $data;
    }

    protected function afterSave(): void
    {
        $this->getRecord()->translateOrNew(app()->getLocale())->fill([
            'name' => $this->data['name'],
        ])->save();
    }
}
