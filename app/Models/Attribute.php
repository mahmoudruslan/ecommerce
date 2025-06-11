<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;
    protected $fillable = ['name_ar','name_en', 'type', 'code'];
    public $timestamps = true;

    public function values()
    {
        return $this->hasMany(AttributeValue::class);
    }
}
