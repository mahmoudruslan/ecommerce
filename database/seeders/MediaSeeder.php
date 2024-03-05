<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Media;

class MediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $images [] = ['file_name' => 'product-1.jpg', 'file_size' => rand(100, 900), 'file_type' => 'image/jpg', 'file_sort' => '0', 'status' => true];
        $images [] = ['file_name' => 'product-2.jpg', 'file_size' => rand(100, 900), 'file_type' => 'image/jpg', 'file_sort' => '0', 'status' => true];
        $images [] = ['file_name' => 'product-3.jpg', 'file_size' => rand(100, 900), 'file_type' => 'image/jpg', 'file_sort' => '0', 'status' => true];
        $images [] = ['file_name' => 'product-4.jpg', 'file_size' => rand(100, 900), 'file_type' => 'image/jpg', 'file_sort' => '0', 'status' => true];
        $images [] = ['file_name' => 'product-5.jpg', 'file_size' => rand(100, 900), 'file_type' => 'image/jpg', 'file_sort' => '0', 'status' => true];
        $images [] = ['file_name' => 'product-6.jpg', 'file_size' => rand(100, 900), 'file_type' => 'image/jpg', 'file_sort' => '0', 'status' => true];
        $images [] = ['file_name' => 'product-7.jpg', 'file_size' => rand(100, 900), 'file_type' => 'image/jpg', 'file_sort' => '0', 'status' => true];
        $images [] = ['file_name' => 'product-8.jpg', 'file_size' => rand(100, 900), 'file_type' => 'image/jpg', 'file_sort' => '0', 'status' => true];
        $images [] = ['file_name' => 'product-9.jpg', 'file_size' => rand(100, 900), 'file_type' => 'image/jpg', 'file_sort' => '0', 'status' => true];
        $images [] = ['file_name' => 'product-10.jpg', 'file_size' => rand(100, 900), 'file_type' => 'image/jpg', 'file_sort' => '0', 'status' => true];
        $images [] = ['file_name' => 'product-11.jpg', 'file_size' => rand(100, 900), 'file_type' => 'image/jpg', 'file_sort' => '0', 'status' => true];
        $images [] = ['file_name' => 'product-12.jpg', 'file_size' => rand(100, 900), 'file_type' => 'image/jpg', 'file_sort' => '0', 'status' => true];

        Media::insert($images);
    }
}
