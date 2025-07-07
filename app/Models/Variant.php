<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'price', 'sku', 'quantity'];
    public $timestamps = true;

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function attributeValues()
    {
        return $this->hasMany(VariantAttribute::class);
    }

    public function media()
    {
        return $this->morphMany(Media::class, 'mediable')->where('media_type', 'image');
    }
    public function firstMedia()
    {
        return $this->morphOne(Media::class, 'mediable')->where('media_type', 'image');
    }

}
