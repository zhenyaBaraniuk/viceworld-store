<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class AttributeValue extends Model
{
    use HasUlids;

    public $timestamps = false;

    protected $fillable = [
        'attribute_id',
        'value',
        'color',
    ];

    /**
     * @return BelongsToMany<ProductVariant, $this>
     */
    public function productVariants(): BelongsToMany
    {
        return $this->belongsToMany(ProductVariant::class);
    }

    /**
     * @return BelongsTo<Attribute, $this>
     */
    public function attribute(): BelongsTo
    {
        return $this->belongsTo(Attribute::class);
    }
}
