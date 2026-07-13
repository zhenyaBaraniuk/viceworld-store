<?php

namespace App\Filament\Resources\Attributes\Pages;

use App\Filament\Resources\Attributes\AttributeResource;
use App\Models\Attribute;
use Filament\Resources\Pages\CreateRecord;

/**
 * @method Attribute getRecord()
 */
class CreateAttribute extends CreateRecord
{
    protected static string $resource = AttributeResource::class;

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Attribute created';
    }

    protected function afterCreate(): void
    {
        $this->getRecord()->translateOrNew(app()->getLocale())->fill([
            'name' => $this->data['name'],
        ])->save();
    }
}
