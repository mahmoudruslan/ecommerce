<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = ['name_ar','name_en','slug','price','description_ar','description_en' , 'quantity','category_id','featured','status'];
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

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function media()
    {
        return $this->morphMany(Media::class, 'mediable');
    }

    public function firstMedia()
    {
        return $this->morphOne(Media::class, 'mediable');
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
    
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

}
