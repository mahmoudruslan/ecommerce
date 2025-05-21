<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    use HasFactory;

    protected $fillable = ['attribute_id', 'id', 'name'];
    public $timestamps = true;

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }
}
