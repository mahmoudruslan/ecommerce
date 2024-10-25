<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function scopeActive($query)
    {
        return $query->whereStatus(true);
    }
    public function checkUsedTimes()
    {
        return $this->use_times != null ? ($this->use_times > $this->used_times ? true : false) : true;
    }
    public function checkDate()
    {
        return $this->start_date != null ? (Carbon::now()->between($this->start_date, $this->expire_date) ? true : false) : true;
    }
    public function checkGreaterThan($sub_total)
    {
        return $sub_total > $this->greater_than ? true : false;
    }

    public function couponValue($total)
    {
        switch ($this->type) {
            case  'fixed':
                return $this->value;
            case 'percentage':
                return ($total * $this->value) / 100;
            default:
                return 0;
        }
    }
}
