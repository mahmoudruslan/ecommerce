<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderTransaction extends Model
{
    use HasFactory;
    protected $guarded = [];

    const PENDING = 0;
    const PAYMENT_COMPLETED = 1;
    const PROCESSING = 2;
    const REJECTED = 3;
    const CANCELED = 4;
    const FINISHED = 5;
    const REFUND_REQUEST = 6;
    const RETURNED_ORDER = 7;
    const REFUNDED = 8;

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function status()
    {
        switch ($this->transaction) {
            case 0: $result = __('Pending'); break;
            case 1: $result = __('Payment completed'); break;
            case 2: $result = __('Processing'); break;
            case 3: $result = __('Rejected'); break;
            case 4: $result = __('Canceled'); break;
            case 5: $result = __('Finished'); break;
            case 6: $result = __('Refund request'); break;
            case 7: $result = __('Returned order'); break;
            case 8: $result = __('Refunded'); break;

            default:
                $result = __('Some problem'); break;
                break;
        }
        return $result;
    }
    public function statusWithHtml()
    {
        switch ($this->transaction) {
            case 0: $result = '<label class="p-1 btn-secondary">' . __('Pending') . '</label>'; break;
            case 1: $result = '<label class="p-1 btn-info">' . __('Payment completed') . '</label>'; break;
            case 2: $result = '<label class="p-1 btn-info">' . __('Processing') . '</label>'; break;
            case 3: $result = '<label class="p-1 btn-danger">' . __('Rejected') . '</label>'; break;
            case 4: $result = '<label class="p-1 btn-danger">' . __('Canceled') . '</label>'; break;
            case 5: $result = '<label class="p-1 btn-success">' . __('Finished') . '</label>'; break;
            case 6: $result = '<label class="p-1 btn-warning">' . __('Refund request') . '</label>'; break;
            case 7: $result = '<label class="p-1 btn-info">' . __('Returned order') . '</label>'; break;
            case 8: $result = '<label class="p-1 btn-info">' . __('Refunded') . '</label>'; break;

            default:
                $result = __('Some problem'); break;
                break;
        }
        return $result;
    }
}
