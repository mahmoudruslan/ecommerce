<?php
namespace App\Services\Contracts;

interface PaymentInterface {
    public function process($billing, $order_id, $total, $currency);
    public function callback();
}
