<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\Governorate;
use App\Models\UserAddress;
use Illuminate\Database\Seeder;
use App\Models\OrderTransaction;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $latest_order = Order::orderBy('created_at', 'DESC')->first();
        $products = Product::inRandomOrder()->activeCategory()->active()->hasQuantity()->take(3)->get();
        $coupon = Coupon::find(1);
        $governorate = Governorate::find(1);
        $city = City::where('governorate_id', $governorate->id)->first();
        // order 1
        $order1 = Order::create([
            'user_id' => 24,
            'user_address_id' => UserAddress::where('user_id', 24)->first()->id,
            'order_address_id' => null,
            'payment_method' => 'card',
            'discount_code' => $coupon->code,
            'shipping' => $governorate->cost,
            'ref_id' => '#' . str_pad(($latest_order ? $latest_order->id : 0) + 1, 8, "0", STR_PAD_LEFT),
            'currency' => 'EGP',
            'discount' => $coupon->value,
            'total' => ($products->sum('price') - $coupon->value) + $governorate->cost,
            'sub_total' => $products->sum('price'),
            'status' => Order::FINISHED,
        ]);

        // order products
        foreach ($products as $product) {
            DB::table('order_product')->insert([
                'order_id' => $order1->id,
                'product_id' => $product->id,
                'quantity' => rand(1, 5),
                'price' => $product->price,

            ]);
            // $order1->products()->attach([
            //     'price' => '50'
            // ]);
        }
        // order transactions
        OrderTransaction::create([
            'order_id' => $order1->id,
            'transaction' => Order::PENDING,
            'transaction_number' => null,
            'payment_result' => null,
            'payment_method' => 'card'
        ]);
        OrderTransaction::create([
            'order_id' => $order1->id,
            'transaction' => Order::PAYMENT_COMPLETED,
            'transaction_number' => $num = rand(000000, 111111),
            'payment_result' => 'success',
            'payment_method' => 'card'
        ]);
        OrderTransaction::create([
            'order_id' => $order1->id,
            'transaction' => Order::PROCESSING,
            'transaction_number' => $num,
            'payment_result' => 'success',
            'payment_method' => 'card'
        ]);
        OrderTransaction::create([
            'order_id' => $order1->id,
            'transaction' => Order::FINISHED,
            'transaction_number' => $num,
            'payment_result' => 'success',
            'payment_method' => 'card'
        ]);
        ///////////////////////////////////////////////////order 2/////////////////////////////////////
        $products = Product::inRandomOrder()->activeCategory()->active()->hasQuantity()->take(3)->get();
        $order2 = Order::create([
            'user_id' => 24,
            'user_address_id' => UserAddress::where('user_id', 24)->first()->id,
            'order_address_id' => null,
            'payment_method' => 'card',
            'discount_code' => null,
            'ref_id' => '#' . str_pad($order1->id + 1, 8, "0", STR_PAD_LEFT),
            'currency' => 'EGP',
            'discount' => 0.00,
            'shipping' => $governorate->cost,
            'total' => $products->sum('price') + $governorate->cost,
            'sub_total' => $products->sum('price'),
            'status' => Order::PAYMENT_COMPLETED,
        ]);
        // order products
        foreach ($products as $product) {
            DB::table('order_product')->insert([
                'order_id' => $order2->id,
                'product_id' => $product->id,
                'quantity' => rand(1, 5),
                'price' => $product->price,

            ]);
        }
        // order transactions
        OrderTransaction::create([
            'order_id' => $order2->id,
            'transaction' => Order::PENDING,
            'transaction_number' => null,
            'payment_result' => null,
            'payment_method' => 'card'
        ]);
        OrderTransaction::create([
            'order_id' => $order2->id,
            'transaction' => Order::PAYMENT_COMPLETED,
            'transaction_number' => $num = rand(000000, 111111),
            'payment_result' => 'success',
            'payment_method' => 'card'
        ]);
        ////////////////////////////////////////////order 3///////////////////////////////////////////////
        $products = Product::inRandomOrder()->activeCategory()->active()->hasQuantity()->take(3)->get();
        $order3 = Order::create([
            'user_id' => 24,
            'user_address_id' => UserAddress::where('user_id', 24)->first()->id,
            'order_address_id' => null,
            'payment_method' => 'card',
            'discount_code' => $coupon->code,
            'ref_id' => '#' . str_pad($order2->id + 1, 8, "0", STR_PAD_LEFT),
            'currency' => 'EGP',
            'discount' => $coupon->value,
            'shipping' => $governorate->cost,
            'total' => ($products->sum('price') - $coupon->value) + $governorate->cost,
            'sub_total' => $products->sum('price'),
            'status' => Order::CANCELED
        ]);
        // order products
        foreach ($products as $product) {
            DB::table('order_product')->insert([
                'order_id' => $order3->id,
                'product_id' => $product->id,
                'quantity' => rand(1, 5),
                'price' => $product->price,

            ]);
        }
        // order transactions
        OrderTransaction::create([
            'order_id' => $order3->id,
            'transaction' => Order::PENDING,
            'transaction_number' => null,
            'payment_result' => null,
            'payment_method' => 'card'
        ]);
        OrderTransaction::create([
            'order_id' => $order3->id,
            'transaction' => Order::CANCELED,
            'transaction_number' => $num = rand(000000, 111111),
            'payment_result' => 'failed',
            'payment_method' => 'card'
        ]);
        /////////////////////////////////////order 4///////////////////////////////////////
        $products = Product::inRandomOrder()->activeCategory()->active()->hasQuantity()->take(3)->get();
        $order4 = Order::create([
            'user_id' => 24,
            'user_address_id' => UserAddress::where('user_id', 24)->first()->id,
            'order_address_id' => null,
            'payment_method' => 'cash-on-delivery',
            'discount_code' => $coupon->code,
            'ref_id' => '#' . str_pad($order3->id + 1, 8, "0", STR_PAD_LEFT),
            'currency' => 'EGP',
            'discount' => $coupon->value,
            'shipping' => $governorate->cost,
            'total' => ($products->sum('price') - $coupon->value) + $governorate->cost,
            'sub_total' => $products->sum('price'),
            'status' => Order::FINISHED
        ]);
        // order products
        foreach ($products as $product) {
            DB::table('order_product')->insert([
                'order_id' => $order4->id,
                'product_id' => $product->id,
                'quantity' => rand(1, 5),
                'price' => $product->price,

            ]);
        }
        // order transactions
        OrderTransaction::create([
            'order_id' => $order4->id,
            'transaction' => Order::PENDING,
            'transaction_number' => null,
            'payment_result' => null,
            'payment_method' => 'cash-on-delivery'
        ]);
        OrderTransaction::create([
            'order_id' => $order4->id,
            'transaction' => Order::PROCESSING,
            'transaction_number' => null,
            'payment_result' => null,
            'payment_method' => 'cash-on-delivery'
        ]);
        OrderTransaction::create([
            'order_id' => $order4->id,
            'transaction' => Order::PAYMENT_COMPLETED,
            'transaction_number' => null,
            'payment_result' => 'success',
            'payment_method' => 'cash-on-delivery',
        ]);
        OrderTransaction::create([
            'order_id' => $order4->id,
            'transaction' => Order::FINISHED,
            'transaction_number' => null,
            'payment_result' => 'success',
            'payment_method' => 'cash-on-delivery'
        ]);
        /////////////////////////////////////////////////////order 5//////////////////////////////////
        $products = Product::inRandomOrder()->activeCategory()->active()->hasQuantity()->take(3)->get();
        $order5 = Order::create([
            'user_id' => 24,
            'user_address_id' => UserAddress::where('user_id', 24)->first()->id,
            'order_address_id' => null,
            'payment_method' => 'cash-on-delivery',
            'discount_code' => $coupon->code,
            'ref_id' => '#' . str_pad($order4->id + 1, 8, "0", STR_PAD_LEFT),
            'currency' => 'EGP',
            'discount' => $coupon->value,
            'shipping' => $governorate->cost,
            'total' => ($products->sum('price') - $coupon->value) + $governorate->cost,
            'sub_total' => $products->sum('price'),
            'status' => Order::PENDING
        ]);
        // order products
        foreach ($products as $product) {
            DB::table('order_product')->insert([
                'order_id' => $order5->id,
                'product_id' => $product->id,
                'quantity' => rand(1, 5),
                'price' => $product->price,

            ]);
        }
        // order transactions
        OrderTransaction::insert([
            'order_id' => $order5->id,
            'transaction' => Order::PENDING,
            'transaction_number' => null,
            'payment_result' => null,
            'payment_method' => 'cash-on-delivery',
        ]);
    }
}
