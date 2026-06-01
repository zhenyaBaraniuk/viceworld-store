<?php

namespace App\Services;

use App\Enums\Product\ProductStatus;
use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class CatalogService
{
    public function getProducts(array $filters): LengthAwarePaginator
    {
        $query = Product::query()
            ->with(['translations', 'media', 'category.translations'])
            ->where('status', '=', ProductStatus::ACTIVE);

        $filteredProducts = $this->applyFilters($query, $filters);

        return $filteredProducts
            ->paginate(12)
            ->withQueryString()
            ->through(function ($product) {
                return [
                    'category_name' => $product->category->name,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'price' => $product->price,
                    'main_image' => $product->getFirstMediaUrl('main_image'),
                ];
            });
    }

    public function getSubCategoriesByParent(string $slug): Collection
    {
        $category = Category::query()
            ->whereTranslation('slug', $slug)
            ->with('children.translations')
            ->firstOrFail();

        return $category->children
            ->map(function ($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'slug' => $category->slug,
                ];
            });
    }

    public function getColors(): Collection
    {
        return AttributeValue::query()
            ->whereNotNull('color')
            ->whereHas('productVariants.product', function (Builder $query) {
                $query->where('status', '=', ProductStatus::ACTIVE);
            })
            ->select(['value', 'color'])
            ->distinct()
            ->get()
            ->map(fn ($item) => [
                'value' => $item->value,
                'hex' => $item->color,
            ]);
    }

    public function getMaxPrice(): int
    {
        $maxPrice = (int) Product::where('status', ProductStatus::ACTIVE)->max('price');

        return (int) ceil($maxPrice / 100) * 100;
    }

    private function applyFilters(Builder $query, array $filters): Builder
    {
        foreach ($filters as $key => $value) {
            match ($key) {
                'child_category_slug' => $query->whereHas('category.translations',
                    fn ($q) => $q->whereIn('slug', (array) $value)),

                'size' => $query->whereHas('productVariants.attributeValues',
                    fn ($q) => $q->whereIn('value', (array) $value)),

                'color' => $query->whereHas('productVariants.attributeValues',
                    fn ($q) => $q->whereIn('value', (array) $value)->whereNotNull('color')),

                'price' => $query->where('price', '<=', $value),

                default => null,
            };
        }

        return $query;
    }
}
