<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
                'name_ar' => fake()->unique()->name(),
                'name_en' => fake()->unique()->word(),
                'price' => rand(50, 5000),
                'description_ar' => fake()->unique()->sentence(),
                'description_en' => fake()->unique()->sentence(),
                'quantity' => rand(1, 200),
                'category_id' => Category::all()->random()->id,
                'featured' => rand(0, 1),
                'status' => rand(0, 1),
        ];
    }
}
