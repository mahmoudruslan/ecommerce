<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'name_ar', 'name_en', 'governorate_id', 'status'];
    public $timestamps = false;
}
