<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getStatusAttribute($value){
        return $value ? __('Active') : __('Not active');
    }
    public function getFullNameAttribute()
    {
        return ucfirst($this->first_name . ' ' . $this->last_name);
    }
}
