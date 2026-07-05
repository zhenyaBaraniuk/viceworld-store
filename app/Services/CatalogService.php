<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use App\Services\Concerns\FiltersProducts;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class CatalogService
{
    use FiltersProducts;

    public function getProducts(array $filters): LengthAwarePaginator
    {
        $query = Product::query()->active()
            ->with(['translations', 'media', 'category.translations']);

        return $this->applyFilters($query, $filters)
            ->paginate(12)
            ->withQueryString();
    }

    public function getSubCategoriesByParent(string $slug): Collection
    {
        return Category::query()
            ->whereTranslation('slug', $slug)
            ->with('children.translations')
            ->firstOrFail()
            ->children;
    }
}
