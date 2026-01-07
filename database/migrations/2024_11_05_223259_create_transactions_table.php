<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->string('invoice_number')->nullable();
            $table->string('payment_result')->nullable();
            $table->string('payment_method')->nullable();
            $table->integer('status')->default(301);// pending
            $table->string('amount')->nullable();
            $table->string('currency')->nullable();
            $table->string('vat')->nullable();
            $table->string('tax')->nullable();
            $table->string('total')->nullable();
            $table->string('subtotal')->nullable();
            $table->string('discount')->nullable();
            $table->string('coupon')->nullable();
            $table->json('custom_field')->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_transactions');
    }
};
