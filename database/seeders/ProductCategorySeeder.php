<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Arr;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //create product categories in pivot table
        $categories = Category::whereNotNull('parent_id')->pluck('id')->toArray();
        Product::all()->each(function ($product) use ($categories) {
            $product->categories()->sync(Arr::random($categories, rand(1, 3)));
        });
    }
}
