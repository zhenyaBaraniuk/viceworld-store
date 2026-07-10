<?php

namespace Database\Factories;

use App\Enums\GenderLine;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'parent_id' => null,
            'gender_line' => GenderLine::WOMEN->value,
            'is_active' => true,
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Category $category) {
            $category->translateOrNew('en')->fill([
                'name' => fake()->words(3, true),
                'slug' => fake()->unique()->slug,
                'description' => fake()->sentence(),
            ]);

            $category->save();
        });
    }
}
