<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VariantAttribute extends Model
{
    use HasFactory;

    protected $fillable = ['variant_id', 'attribute_id', 'attribute_value_id'];
    public $timestamps = true;

    public function variant()
    {
        return $this->belongsTo(Variant::class);
    }
    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }
    public function value()
    {
        return $this->belongsTo(AttributeValue::class, 'attribute_value_id');
    }
}
