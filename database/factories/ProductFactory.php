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
        $categories = Category::whereNotNull('parent_id')->pluck('id');
        return [
                'name_ar' => fake()->name(),
                'name_en' => fake()->word(),
                'price' => rand(50, 5000),
                'description_ar' => fake()->sentence(),
                'description_en' => fake()->sentence(),
                'quantity' => rand(1, 200),
                'category_id' => $categories->random(),
                'featured' => rand(0, 1),
                'status' => rand(0, 1),
        ];
    }
}
