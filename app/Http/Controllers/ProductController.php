<?php

namespace App\Http\Controllers;

use App\Data\Category\CategoryData;
use App\Data\Product\ProductData;
use App\Data\Product\ProductShortData;
use App\Services\ProductService;
use Inertia\Inertia;
use Inertia\Response;

class ProductController extends Controller
{
    public function __construct(
        private readonly ProductService $productService,
    ) {}

    public function show(string $slug): Response
    {
        $product = $this->productService->getProductBySlug($slug);

        $category = $product->category;

        $relatedProducts = $this->productService->getRelatedProducts($product);

        return Inertia::render('Product/index', [
            'product' => ProductData::fromModel($product),
            'category' => CategoryData::from($category),
            'related_products' => $relatedProducts->map(fn ($relatedProduct) => ProductShortData::fromModel($relatedProduct)),
        ]);
    }
}
