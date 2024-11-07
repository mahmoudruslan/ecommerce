<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderTransaction extends Model
{
    use HasFactory;
    protected $guarded = [];

    const NEW_ORDER = 0;
    const PAYMENT_COMPLETED = 1;
    const UNDER_PROCESS = 2;
    const FINISHED = 3;
    const REJECTED = 4;
    const CANCELED = 5;
    const REFUNDED_REQUEST = 6;
    const REFUNDED = 7;
    const RETURNED = 8;

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function status()
    {
        switch ($this->status) {
            case 0:
                $result = __('New order');
                break;
            case 1:
                $result = __('Payment completed');
                break;
            case 2:
                $result = __('Under process');
                break;
            case 3:
                $result = __('Finished');
                break;
            case 4:
                $result = __('Rejected');
                break;
            case 5:
                $result = __('Canceled');
                break;
            case 6:
                $result = __('Refund request');
                break;
            case 7:
                $result = __('Refunded');
                break;
            case 8:
                $result = __('Returned');
                break;

            default:
                $result = __('Some problem');
                break;
                break;
        }
        return $result;
    }
}
