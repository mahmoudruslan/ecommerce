<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use App\Models\Tag;
use Illuminate\Support\Arr;

class CategoryTagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = Tag::whereStatus(true)->pluck('id')->toArray();
        Category::all()->each(function($category) use ($tags){
            $category->tags()->attach(Arr::random($tags, rand(2, 3)));
        });
    }
}
