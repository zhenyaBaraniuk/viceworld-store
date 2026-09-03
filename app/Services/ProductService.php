<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Collection;

class ProductService
{
    public function getProductBySlug(string $slug): Product
    {
        return Product::query()->whereTranslation('slug', $slug)
            ->with([
                'media',
                'translations',
                'category.translations',
                'productVariants.attributeValues.attribute',
            ])
            ->firstOrFail();
    }

    public function getRelatedProducts(Product $product): Collection
    {
        return $product->related()
            ->with(['mediaFiles', 'translations'])
            ->limit(4)
            ->get();
    }
}
