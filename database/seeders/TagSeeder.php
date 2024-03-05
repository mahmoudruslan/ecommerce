<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tag;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            Tag::create([
                'name_ar' => 'ملابس',
                'name_en' => 'Clothes',
            ]);
            Tag::create([
                'name_ar' => 'أحذية',
                'name_en' => 'Shoes',
            ]);
            Tag::create([
                'name_ar' => 'ساعات',
                'name_en' => 'Watches',
            ]);
            Tag::create([
                'name_ar' => 'إلكترونيات',
                'name_en' => 'Electronics',
            ]);
            Tag::create([
                'name_ar' => 'رجال',
                'name_en' => 'Men',
            ]);
            Tag::create([
                'name_ar' => 'نساء',
                'name_en' => 'Women',
            ]);
            Tag::create([
                'name_ar' => 'أولاد',
                'name_en' => 'Boys',
            ]);
            Tag::create([
                'name_ar' => 'بنات',
                'name_en' => 'Girls',
            ]);

    }
}
