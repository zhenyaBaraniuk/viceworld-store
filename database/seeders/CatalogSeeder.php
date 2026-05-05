<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use App\Models\AttributeValue;
use Illuminate\Database\Seeder;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\Product;
use Throwable;

class CatalogSeeder extends Seeder
{
    /**
     * @throws Throwable
     */
    public function run(): void
    {
        $data = require __DIR__ . '/data/catalog.php';

        $categories = $data['categories'];
        $attributes = $data['attributes'];
        $products = $data['products'];

        DB::transaction(function () use ($categories, $attributes, $products) {
            $this->fillCategories($categories);
            $this->fillAttributes($attributes);
            $this->fillProducts($products);
        });

        $this->command->info('Catalog seeded successfully');
    }

    public function fillCategories(array $categories): void
    {
        foreach ($categories as $category) {
            $parent = Category::create([
                'gender_line' => $category['gender_line'],
                'is_active' => $category['is_active'],
            ]);

            $parent->translateOrNew('en')->fill([
                'name' => $category['name'],
                'slug' => $category['slug'],
                'description' => $category['description'],
            ])->save();

            foreach ($category['children'] as $child) {
                $childModel = Category::create([
                    'parent_id' => $parent->id,
                    'gender_line' => $child['gender_line'],
                ]);

                $childModel->translateOrNew('en')->fill([
                    'name' => $child['name'],
                    'slug' => $child['slug'],
                    'description' => $child['description'],
                ])->save();
            }
        }
    }

    public function fillAttributes(array $attributes): void
    {
        foreach ($attributes as $attribute) {
            $createdAttribute = Attribute::create([]);

            $createdAttribute->translateOrNew('en')->fill([
                'name' => $attribute['name'],
            ])->save();

            foreach ($attribute['values'] as $value) {
                AttributeValue::create([
                    'attribute_id' => $createdAttribute->id,
                    'value' => $value['value'],
                    'color' => $value['color'],
                ]);
            }
        }
    }

    public function fillProducts(array $products): void
    {
        foreach ($products as $product) {
            $categorySlug = $product['category'];
            $category = Category::whereTranslation('slug', $categorySlug)->firstOrFail();

            $createdProduct = Product::create([
                'price' => $product['price'],
                'status' => $product['status'],
                'gender_line' => $product['gender_line'],
                'is_featured' => $product['is_featured'],
                'category_id' => $category->id,
            ]);

            $createdProduct->translateOrNew('en')->fill([
                'name' => $product['name'],
                'slug' => $product['slug'],
                'description' => $product['description'],
            ])->save();
        }
    }
}
