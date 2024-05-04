<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function  governorate()
    {
        return $this->belongsTo(Governorate::class);
    }

    public function  city()
    {
        return $this->belongsTo(City::class);
    }
}
