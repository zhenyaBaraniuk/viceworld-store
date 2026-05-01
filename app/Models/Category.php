<?php

namespace App\Models;

use App\Enums\GenderLine;
use App\Filament\Trait\HasTranslateAttributes;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Category extends Model implements HasMedia, TranslatableContract
{
    use HasTranslateAttributes, HasUlids, InteractsWithMedia, Translatable;

    protected $fillable = [
        'parent_id',
        'gender_line',
        'is_active',
    ];

    public array $translatedAttributes = [
        'name',
        'slug',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'gender_line' => GenderLine::class,
            'is_active' => 'boolean',
        ];
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function mediaFiles(): MorphToMany
    {
        return $this->morphToMany(Media::class, 'mediable')
            ->using(Mediable::class)
            ->withPivot('collection', 'order');
    }

    public function getDescendantIds(): array
    {
        $ids = [];

        foreach ($this->children as $child) {
            $ids[] = $child->id;

            array_push($ids, ...$child->getDescendantIds());
        }

        return $ids;
    }
}
