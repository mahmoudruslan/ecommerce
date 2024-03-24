<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use App\Models\Product;
use App\Models\Media;

class ProductMediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products_ids = Product::pluck('id')->toArray();

        $images [] = ['file_name' => 'images/products/product-1.jpg', 'file_size' => rand(100, 900), 'file_type' => 'image/jpg', 'file_sort' => '0', 'status' => true];
        $images [] = ['file_name' => 'images/products/product-2.jpg', 'file_size' => rand(100, 900), 'file_type' => 'image/jpg', 'file_sort' => '0', 'status' => true];
        $images [] = ['file_name' => 'images/products/product-3.jpg', 'file_size' => rand(100, 900), 'file_type' => 'image/jpg', 'file_sort' => '0', 'status' => true];
        $images [] = ['file_name' => 'images/products/product-4.jpg', 'file_size' => rand(100, 900), 'file_type' => 'image/jpg', 'file_sort' => '0', 'status' => true];
        $images [] = ['file_name' => 'images/products/product-5.jpg', 'file_size' => rand(100, 900), 'file_type' => 'image/jpg', 'file_sort' => '0', 'status' => true];
        $images [] = ['file_name' => 'images/products/product-6.jpg', 'file_size' => rand(100, 900), 'file_type' => 'image/jpg', 'file_sort' => '0', 'status' => true];
        $images [] = ['file_name' => 'images/products/product-7.jpg', 'file_size' => rand(100, 900), 'file_type' => 'image/jpg', 'file_sort' => '0', 'status' => true];
        $images [] = ['file_name' => 'images/products/product-8.jpg', 'file_size' => rand(100, 900), 'file_type' => 'image/jpg', 'file_sort' => '0', 'status' => true];
        $images [] = ['file_name' => 'images/products/product-9.jpg', 'file_size' => rand(100, 900), 'file_type' => 'image/jpg', 'file_sort' => '0', 'status' => true];
        $images [] = ['file_name' => 'images/products/product-10.jpg', 'file_size' => rand(100, 900), 'file_type' => 'image/jpg', 'file_sort' => '0', 'status' => true];
        $images [] = ['file_name' => 'images/products/product-11.jpg', 'file_size' => rand(100, 900), 'file_type' => 'image/jpg', 'file_sort' => '0', 'status' => true];
        $images [] = ['file_name' => 'images/products/product-12.jpg', 'file_size' => rand(100, 900), 'file_type' => 'image/jpg', 'file_sort' => '0', 'status' => true];

        Product::get()->each(function ($product) use ($images){
            for($i=0; $i < rand(2,4); $i++){
            $product->media()->create(Arr::random($images));  
            }
        });

    }
}
