<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Clothes = Category::create(['name_ar' => 'ملابس','name_en' => 'Clothes','image' => 'avatar.svg', 'parent_id' => null]);
                Category::create(['name_ar' => 'رجال','name_en' => 'Men','image' => 'avatar.svg', 'parent_id' => $Clothes->id]);
                Category::create(['name_ar' => 'نساء','name_en' => 'Women','image' => 'avatar.svg', 'parent_id' => $Clothes->id]);
                Category::create(['name_ar' => 'أولاد','name_en' => 'Boys','image' => 'avatar.svg', 'parent_id' => $Clothes->id]);
                Category::create(['name_ar' => 'بنات','name_en' => 'Girls','image' => 'avatar.svg', 'parent_id' => $Clothes->id]);
        $Shoes = Category::create(['name_ar' => 'أحذية','name_en' => 'Shoes','image' => 'avatar.svg', 'parent_id' => null]);
                Category::create(['name_ar' => 'رجال','name_en' => 'Men','image' => 'avatar.svg', 'parent_id' => $Shoes->id]);
                Category::create(['name_ar' => 'نساء','name_en' => 'Women','image' => 'avatar.svg', 'parent_id' => $Shoes->id]);
                Category::create(['name_ar' => 'أولاد','name_en' => 'Boys','image' => 'avatar.svg', 'parent_id' => $Shoes->id]);
                Category::create(['name_ar' => 'بنات','name_en' => 'Girls','image' => 'avatar.svg', 'parent_id' => $Shoes->id]);
        $Watches = Category::create(['name_ar' => 'ساعات','name_en' => 'Watches','image' => 'avatar.svg', 'parent_id' => null]);
                Category::create(['name_ar' => 'رجال','name_en' => 'Men','image' => 'avatar.svg', 'parent_id' => $Watches->id]);
                Category::create(['name_ar' => 'نساء','name_en' => 'Women','image' => 'avatar.svg', 'parent_id' => $Watches->id]);
                Category::create(['name_ar' => 'أولاد','name_en' => 'Boys','image' => 'avatar.svg', 'parent_id' => $Watches->id]);
                Category::create(['name_ar' => 'بنات','name_en' => 'Girls','image' => 'avatar.svg', 'parent_id' => $Watches->id]);
        $Electronics = Category::create(['name_ar' => 'إلكترونيات','name_en' => 'Electronics','image' => 'avatar.svg', 'parent_id' => null]);
                Category::create(['name_ar' => 'فلاشات','name_en' => 'USP flash drive','image' => 'avatar.svg', 'parent_id' => $Electronics->id]);
                Category::create(['name_ar' => 'سماعات رأس','name_en' => 'Headphones','image' => 'avatar.svg', 'parent_id' => $Electronics->id]);
                Category::create(['name_ar' => 'سماعات محمولة','name_en' => 'Portable speakers','image' => 'avatar.svg', 'parent_id' => $Electronics->id]);
                Category::create(['name_ar' => 'سماعات بلوتوث','name_en' => 'Call phones bluetooth headsets','image' => 'avatar.svg', 'parent_id' => $Electronics->id]);
                Category::create(['name_ar' => 'لوحات مفاتيح','name_en' => 'keyboards','image' => 'avatar.svg', 'parent_id' => $Electronics->id]);


    }
}
