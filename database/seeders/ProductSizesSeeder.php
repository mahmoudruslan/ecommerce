<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Size;
use Illuminate\Support\Arr;

class ProductSizesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //create sizes
        Product::all()->each(function ($product) {
            $sizes = Size::take(rand(1, 5))->inRandomOrder()->get();
            $sizesData = [];
            foreach ($sizes as $size) {
               $sizesData[$size->id] = [
                'quantity' => rand(2, 7),
               ];
            }
            $product->sizes()->sync($sizesData);
        });
    }
}
