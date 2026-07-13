<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Collection;

class NavigationService
{
    public function getCategories(): Collection
    {
        return Category::query()
            ->where('is_active', '=', true)
            ->whereNull('parent_id')
            ->with('translations')
            ->get()
            ->map(function ($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'slug' => $category->slug,
                ];
            });
    }
}
