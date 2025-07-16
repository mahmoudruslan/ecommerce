<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Variant extends Model
{
    use HasFactory, SoftDeletes;

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
        return $this->morphMany(Media::class, 'mediable');
    }
    public function firstMedia()
    {
        return $this->morphOne(Media::class, 'mediable');
    }

}
