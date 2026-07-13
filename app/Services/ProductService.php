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
        return Product::query()
            ->where('category_id', '=', $product->category_id)
            ->where('id', '!=', $product->id)
            ->with([
                'media',
                'translations',
            ])
            ->limit(4)
            ->get();
    }
}
