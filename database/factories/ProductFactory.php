<?php

namespace Database\Factories;

use App\Enums\GenderLine;
use App\Enums\Product\ProductStatus;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'category_id' => Category::factory(),
            'price' => $this->faker->randomFloat(1, 10, 100),
            'gender_line' => GenderLine::WOMEN->value,
            'status' => ProductStatus::ACTIVE->value,
            'is_featured' => false,
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Product $product) {
            $product->translateOrNew('en')->fill([
                'name' => fake()->words(3, true),
                'slug' => fake()->unique()->slug,
                'description' => fake()->sentence(),
            ]);

            $product->save();
        });
    }
}
