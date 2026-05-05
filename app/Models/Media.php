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

    public function formattedSize(): Attribute
    {
        return Attribute::make(
            get: fn () => number_format($this->size / 1024 / 1024, 1).' MB',
        );
    }

    public function url(): Attribute
    {
        return Attribute::make(
            get: fn () => Storage::url($this->file_name),
        );
    }
}
