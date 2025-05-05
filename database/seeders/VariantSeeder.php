<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Variant;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class VariantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = Product::select('id')->get();
        $images = [
            'images/products/product-1.jpg',
            'images/products/product-2.jpg',
            'images/products/product-3.jpg',
            'images/products/product-4.jpg',
            'images/products/product-5.jpg',
            'images/products/product-6.jpg',
            'images/products/product-7.jpg',
            'images/products/product-8.jpg',
            'images/products/product-9.jpg',
            'images/products/product-10.jpg',
            'images/products/product-11.jpg',
            'images/products/product-12.jpg',
        ];
        foreach ($products as $product)
            Variant::create([
                'product_id' => $product->id,
                'sku' => null,
                'price' => rand(111, 999),
                'quantity' => rand(1, 3),
                'image' => $images[rand(1, 11)],
            ]);
    }
}
