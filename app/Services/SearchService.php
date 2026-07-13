<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use App\Services\Concerns\FiltersProducts;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class SearchService
{
    use FiltersProducts;

    public function search(string $query, array $filters): LengthAwarePaginator
    {
        $q = Product::query()->active()
            ->with(['translations', 'media', 'category.translations']);

        $q->whereHas('translations', fn ($t) => $t
            ->where('name', 'LIKE', "%{$query}%"));

        return $this->applyFilters($q, $filters)
            ->paginate(12)
            ->withQueryString();
    }

    public function getCategories(): Collection
    {
        return Category::query()
            ->whereNull('parent_id')
            ->where('is_active', true)
            ->with('translations')
            ->get();
    }
}
