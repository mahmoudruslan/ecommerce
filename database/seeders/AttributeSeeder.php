<?php

namespace Database\Seeders;

use App\Models\Attribute;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Attribute::create([
            'name_ar' => 'اللون',
            'name_en' => 'Color',
            'code' => 'color',
        ]);
        Attribute::create([
            'name_ar' => 'المقاس',
            'name_en' => 'size',
            'code' => 'size',
        ]);
    }
}
