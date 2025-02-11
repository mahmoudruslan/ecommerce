<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaymentMethod::create([
            'name' => 'Paymob',
            'code' => 'testtest',
            'driver_name' => 'test',
            'merchant_email' => null,
            'username' => null,
            'password' => null,
            'secret' => null,
            'sandbox_username' => null,
            'sandbox_password' => null,
            'sandbox_secret' => null,
        ]);
    }
}
