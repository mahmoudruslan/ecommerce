<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $products_ids = Product::pluck('id')->toArray();
        $users_ids = User::pluck('id')->toArray();

        for ($i = 0; $i < 4000; $i++) { 
            Review::create([
                'user_id' => Arr::random($users_ids), 
                'product_id' => Arr::random($products_ids),
                'name' => fake()->username(), 
                'email' => fake()->safeEmail(), 
                'title' => fake()->sentence(5),  
                'rating' => rand(1,5), 
                'body' => fake()->paragraph(),
                'status' => rand(0, 1),
            ]);
        }
    }
}
