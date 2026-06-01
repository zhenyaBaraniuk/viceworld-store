<?php

namespace App\Http\Controllers;

use App\Services\CatalogService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CatalogController extends Controller
{
    public function __construct(
        private readonly CatalogService $catalogService,
    ) {}

    public function show(Request $request, string $slug): Response
    {
        $filters = array_filter($request->only([
            'child_category_slug', 'size', 'color', 'price',
        ]));

        $filters['parent_category_slug'] = $slug;

        $products = $this->catalogService->getProducts($filters);

        $categories = $this->catalogService->getSubCategoriesByParent($slug);

        $colors = $this->catalogService->getColors();

        return Inertia::render('Catalog/index', [
            'products' => $products,
            'categories' => $categories,
            'filters' => $filters,
            'max_price' => $this->catalogService->getMaxPrice(),
            'colors' => $colors,
        ]);
    }
}
