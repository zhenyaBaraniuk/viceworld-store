<?php

namespace App\Services\Concerns;

use App\Models\AttributeValue;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

trait FiltersProducts
{
    public function getColors(): Collection
    {
        return AttributeValue::query()
            ->whereNotNull('color')
            ->whereHas('productVariants.product', function (Builder $query): void {
                $query->active();
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
        $maxPrice = (int) Product::query()->active()->max('price');

        return (int) ceil($maxPrice / 100) * 100;
    }

    private function applyFilters(Builder $query, array $filters): Builder
    {
        foreach ($filters as $key => $value) {
            match ($key) {
                'category_slug' => $query->whereHas('category.parent.translations',
                    fn ($q) => $q->whereIn('slug', (array) $value)),

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
