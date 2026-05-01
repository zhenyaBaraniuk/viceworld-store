<?php

namespace App\Filament\Resources\Media;

use App\Filament\Resources\Media\Pages\FileManager;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use UnitEnum;

class MediaResource extends Resource
{
    protected static ?string $model = Media::class;

    protected static string|null|UnitEnum $navigationGroup = 'File Manager';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'file_name';

    public static function getPages(): array
    {
        return [
            'index' => FileManager::route('/'),
        ];
    }
}
