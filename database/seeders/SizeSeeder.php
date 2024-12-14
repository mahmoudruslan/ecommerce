<?php

namespace Database\Seeders;

use App\Models\Size;
use App\Models\Category;
use Illuminate\Database\Seeder;

class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Size::create([
        //     'name' => 'One Size',
        // ]);
        Size::create([
            'name' => 'S',
        ]);
        Size::create([
            'name' => 'M',
        ]);
        Size::create([
            'name' => 'L',
        ]);
        Size::create([
            'name' => 'X',
        ]);
        Size::create([
            'name' => 'XL',
        ]);
        Size::create([
            'name' => 'XXL',
        ]);
        Size::create([
            'name' => 'XXXL',
        ]);
    }
}
