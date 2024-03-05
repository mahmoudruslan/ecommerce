<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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

        $media = Media::whereStatus(true)->pluck('id')->toArray();
        Product::all()->each(function($product) use ($media){
            $product->media()->attach(Arr::random($media, rand(2, 3)));
        });

    }
}
