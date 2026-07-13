<?php

namespace App\Models;

use App\Contracts\MediaFileInterface;
use App\Enums\GenderLine;
use App\Filament\Trait\HasTranslateAttributes;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * @property string $name
 * @property string $slug
 * @property string|null $description
 *
 * @method CategoryTranslation translateOrNew(?string $locale = null)
 * @method CategoryTranslation|null translate(?string $locale = null, bool $withFallback = false)
 */
class Category extends Model implements HasMedia, MediaFileInterface, TranslatableContract
{
    use HasFactory, HasTranslateAttributes, HasUlids, InteractsWithMedia, Translatable;

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

    /**
     * @return HasMany<Category, $this>
     */
    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * @return MorphToMany<Media, $this, Mediable>
     */
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
