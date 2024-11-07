<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function order()
    {
        return $this->hasMany(Order::class);
    }
    public function status()
    {
        return $this->status ? __('Active') : __('Inactive');
    }

    public function sandbox()
    {
        return $this->sandbox ? __('Sandbox') : __('Live');
    }
}
