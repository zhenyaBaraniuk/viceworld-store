<?php

namespace Database\Seeders;

use App\Models\AttributeValue;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductVariantSeeder extends Seeder
{
    public function run(): void
    {
        $sizes = AttributeValue::whereHas('attribute', function (Builder $query) {
            $query->whereTranslation('name', 'Size');
        })->get();

        $colors = AttributeValue::whereHas('attribute', function (Builder $query) {
            $query->whereTranslation('name', 'Color');
        })->get();

        Product::all()->each(function (Product $product) use ($sizes, $colors) {
            $productSizes = $sizes->random(2);
            $productColors = $colors->random(2);

            foreach ($productSizes as $size) {
                foreach ($productColors as $color) {

                    $productVariant = ProductVariant::create([
                        'product_id' => $product->id,
                        'price' => $product->price,
                        'stock' => rand(1, 25),
                        'sku' => Str::upper($product->translate('en')->slug.
                            '-'.$size->value.'-'.$color->value),
                        'is_active' => true,
                    ]);

                    $productVariant->attributeValues()->attach([
                        $size->id,
                        $color->id,
                    ]);
                }
            }
        });
    }
}
