<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class HomeService
{
    public function getHeroProduct(): Product
    {
        return Product::query()
            ->whereHas('mediaFiles', function (Builder $query): void {
                $query->where('collection', '=', 'main_image');
            })
            ->latest('created_at')
            ->first();
    }

    public function getNewArrivals(): Collection
    {
        return Product::query()
            ->with('category')
            ->latest('created_at')
            ->take(4)
            ->get();
    }

    public function getCategoryTiles(): Collection
    {
        return Category::query()
            ->whereNull('parent_id')
            ->whereHas('mediaFiles', function (Builder $query): void {
                $query->where('collection', '=', 'main_image');
            })->orderBy('created_at', 'desc')->take(3)
            ->get();
    }
}
