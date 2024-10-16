<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = ['id', 'name_ar','name_en','image','category_id', 'status', 'parent_id'];


    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name_ar')
            ->saveSlugsTo('slug')
            ->usingLanguage('ar');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }
    public function images()
    {
        return $this->morphMany(Media::class, 'mediable');
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function parent()
    {
        return $this->hasOne(Category::class, 'id', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    public function appearChildren()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id')->where('status', true);
    }
    public function scopeActive($query)
    {
        return $query->whereStatus(true);
    }

    public static function tree($level = 1)
    {
        return static::with(implode('.', array_fill(0 , $level, 'children')))
        ->whereNull('parent_id')
        ->whereStatus(true)
        ->orderBy('id', 'asc')
        ->get();
    }
}
