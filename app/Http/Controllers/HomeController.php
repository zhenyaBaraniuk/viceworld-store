<?php

namespace App\Http\Controllers;

use App\Data\Category\CategoryTileData;
use App\Data\Product\ProductListData;
use App\Services\HomeService;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function __construct(
        private readonly HomeService $homeService
    ) {}

    public function __invoke()
    {
        $heroProduct = $this->homeService->getHeroProduct();
        $newArrivals = $this->homeService->getNewArrivals();
        $categoryTiles = $this->homeService->getCategoryTiles();

        return Inertia::render('Home/index', [
            'hero_product' => ProductListData::fromModel($heroProduct),
            'new_arrivals' => $newArrivals->map(fn ($arrival) => ProductListData::fromModel($arrival)),
            'category_tiles' => $categoryTiles->map(fn ($category) => CategoryTileData::fromModel($category)),
        ]);
    }
}
