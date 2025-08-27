<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Variant extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['product_id', 'price', 'sku', 'quantity', 'primary_attribute_id', 'primary_attribute_value_id', 'secondary_attribute_id', 'secondary_attribute_value_id'
];
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
    public function primaryAttribute()
    {
        return $this->belongsTo(Attribute::class, 'primary_attribute_id');
    }
    public function secondaryAttribute()
    {
        return $this->belongsTo(Attribute::class, 'secondary_attribute_id');
    }
    public function primaryAttributeValue()
    {
        return $this->belongsTo(AttributeValue::class, 'primary_attribute_value_id');
    }
    public function secondaryAttributeValue()
    {
        return $this->belongsTo(AttributeValue::class, 'secondary_attribute_value_id');
    }
}
