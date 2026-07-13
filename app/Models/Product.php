<?php

namespace App\Models;

use App\Contracts\MediaFileInterface;
use App\Enums\GenderLine;
use App\Enums\Product\ProductStatus;
use App\Filament\Trait\HasTranslateAttributes;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
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
 * @property array|null $description
 *
 * @method ProductTranslation|null translate(?string $locale = null, bool $withFallback = false)
 */
class Product extends Model implements HasMedia, MediaFileInterface, TranslatableContract
{
    use HasFactory, HasTranslateAttributes, HasUlids, InteractsWithMedia, Translatable;

    protected $fillable = [
        'category_id',
        'price',
        'status',
        'gender_line',
        'is_featured',
    ];

    public array $translatedAttributes = [
        'name',
        'slug',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'status' => ProductStatus::class,
            'gender_line' => GenderLine::class,
            'is_featured' => 'boolean',
        ];
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('main_image')
            ->singleFile();

        $this->addMediaCollection('images');
    }

    /**
     * @return BelongsTo<Category, $this>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return HasMany<ProductVariant, $this>
     */
    public function productVariants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
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

    #[Scope]
    protected function active(Builder $query): Builder
    {
        return $query->where('status', '=', ProductStatus::ACTIVE);
    }
}
