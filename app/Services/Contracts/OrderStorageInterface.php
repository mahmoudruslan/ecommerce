<?php
namespace App\Services\Contracts;

interface OrderStorageInterface {
    public function createOrder($data);
}
