<?php

namespace App\Models;

use App\Filament\Trait\HasTranslateAttributes;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property string $name
 *
 * @method LabelTranslation translateOrNew(?string $locale = null)
 * @method LabelTranslation|null translate(?string $locale = null, bool $withFallback = false)
 */
class Label extends Model implements TranslatableContract
{
    use HasTranslateAttributes, HasUlids, Translatable;

    public $timestamps = false;

    public array $translatedAttributes = [
        'name',
    ];

    /**
     * @return BelongsToMany<Product, $this>
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(
            Product::class,
            'label_product',
            'label_id',
            'product_id',
        )->withPivot('position')->orderByPivot('position');
    }
}
