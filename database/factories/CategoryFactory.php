<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
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
            'image' => 'avatar.svg',
            'status' => rand(0, 1)
        ];
    }
}
