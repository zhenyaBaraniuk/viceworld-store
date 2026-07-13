<?php

namespace App\Http\Controllers;

use App\Data\Category\CategoryData;
use App\Data\Product\ProductListData;
use App\Services\SearchService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SearchController extends Controller
{
    public function __construct(
        private readonly SearchService $searchService
    ) {}

    public function __invoke(Request $request)
    {
        $query = (string) $request->input('q');

        $filters = array_filter($request->only([
            'category_slug', 'size', 'color', 'price',
        ]));

        $products = $this->searchService->search($query, $filters);

        return Inertia::render('Search/index', [
            'products' => $products->through(fn ($product) => ProductListData::fromModel($product)),
            'categories' => $this->searchService->getCategories()->map(fn ($category) => CategoryData::from($category)),
            'filters' => $filters,
            'max_price' => $this->searchService->getMaxPrice(),
            'colors' => $this->searchService->getColors(),
            'query' => $query,
            'total' => $products->total(),
        ]);
    }
}
