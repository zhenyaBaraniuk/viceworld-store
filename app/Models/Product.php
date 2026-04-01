<?php

namespace App\Models;

use App\Enums\GenderLine;
use App\Enums\Product\ProductStatus;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class Product extends Model implements HasMedia, TranslatableContract
{
    use InteractsWithMedia, Translatable;

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

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function productVariants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }
}
