<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Governorate extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'name_ar', 'name_en', 'status'];
    public $timestamps = false;

    public function shippingCompanies()
    {
        return $this->belongsToMany(ShippingCompany::class);
    }
    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
