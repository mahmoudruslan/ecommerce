<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, HasSlug, SoftDeletes;

    protected $guarded = [];
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
    public function images()
    {
        return $this->morphMany(Media::class, 'mediable')->where('media_type', 'image');
    }
    public function firstMedia()
    {
        return $this->morphOne(Media::class, 'mediable')->where('media_type', 'image');
    }
    public function sizeGuide()
    {
        return $this->morphOne(Media::class, 'mediable')->where('media_type', 'size_guide');
    }
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function scopeRating($query)
    {
        return $query->withAvg('reviews', 'rating');
    }

    public function scopeFeatured($query)
    {
        return $query->whereFeatured(true);
    }
    public function scopeActive($query)
    {
        return $query->whereStatus(true);
    }

    // public function scopeHasQuantity($query)
    // {
    //     return $query->where('quantity', '>', 0);
    // }

    public function scopeActiveCategory($query)
    {
        return $query->whereHas('category', function($query) {
            return $query->whereStatus(true);
        });
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class)->withPivot('quantity');
    }
    public function sizes()
    {
        return $this->belongsToMany(Size::class)->withPivot('quantity');
    }
    public function orderProductSize(): BelongsToMany
    {
        return $this->belongsToMany(Size::class, 'order_product');
    }
    public function variants(): HasMany
    {
        return $this->hasMany(Variant::class);
    }
    public function VariantAttributeValues(): HasMany
    {
        return $this->hasMany(VariantAttribute::class);
    }
}
