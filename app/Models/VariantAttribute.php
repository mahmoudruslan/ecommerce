<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VariantAttribute extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'variant_id', 'attribute_id', 'attribute_value_id'];
    public $timestamps = true;

    public function variant(): BelongsTo
    {
        return $this->belongsTo(Variant::class);
    }
    public function attribute(): BelongsTo
    {
        return $this->belongsTo(Attribute::class);
    }
    public function attributeValue(): BelongsTo
    {
        return $this->belongsTo(AttributeValue::class, 'attribute_value_id');
    }
}
