<?php

namespace App\Filament\Resources\Attributes\Pages;

use App\Filament\Resources\Attributes\AttributeResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAttribute extends CreateRecord
{
    protected static string $resource = AttributeResource::class;

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Attribute created';
    }

    protected function afterCreate(): void
    {
        $this->record->translateOrNew(app()->getLocale())->fill([
            'name' => $this->data['name'],
        ])->save();
    }
}
