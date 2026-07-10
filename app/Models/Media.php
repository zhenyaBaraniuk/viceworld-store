<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media as BaseMedia;

class Media extends BaseMedia
{
    protected $guarded = [];

    public function mediaFolder(): BelongsTo
    {
        return $this->belongsTo(MediaFolder::class);
    }

    public static function createFromFile(string $name, string $path, ?string $folderId = null): self
    {
        $disk = config('filesystems.default');
        $storage = Storage::disk($disk);

        return self::query()->create([
            'folder_id' => $folderId,
            'collection_name' => 'default',
            'name' => pathinfo($name, PATHINFO_FILENAME),
            'file_name' => $path,
            'mime_type' => $storage->mimeType($path),
            'size' => $storage->size($path),
            'disk' => $disk,
            'conversions_disk' => config('filesystems.default'),
            'model_type' => null,
            'model_id' => null,
            'manipulations' => [],
            'custom_properties' => [],
            'generated_conversions' => [],
            'responsive_images' => [],
        ]);
    }

    protected function formattedSize(): Attribute
    {
        return Attribute::make(
            get: fn () => number_format($this->size / 1024 / 1024, 1).' MB',
        );
    }

    protected function url(): Attribute
    {
        return Attribute::make(
            get: fn () => Storage::disk($this->disk)->url($this->file_name),
        );
    }
}
