<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingCompany extends Model
{
    use HasFactory;
    protected $fillable = [
        'name_ar',
        'name_en',
        'code',
        'description_ar',
        'description_en',
        'fast',
        'coast',
        'status',
    ];

    public function governorates()
    {
        return $this->belongsToMany(Governorate::class);
    }

    public function status()
    {
        return $this->status == 1 ? __('Active') : __('Inactive');
    }

    public function fast()
    {
        return $this->fast == 1 ? __('Fast') : __('Normal');
    }
}
