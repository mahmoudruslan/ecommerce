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
                'quantity' => rand(1, 7),
                'category_id' => $categories->random(),
                'featured' => rand(0, 1),
                'status' => rand(1, 1),
                'video_link' => 'https://www.youtube.com/watch?v=nN_CF4lzpEE',
                'iframe' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/nN_CF4lzpEE?si=aPcFKgB40vhHmEgp" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>',
        ];
    }
}
