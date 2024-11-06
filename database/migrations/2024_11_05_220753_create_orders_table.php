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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete('cascade');
            $table->foreignId('user_address_id')->nullable()->constrained()->nullOnDelete('cascade');
            $table->foreignId('payment_method_id')->constrained()->nullOnDelete('cascade');
            $table->foreignId('order_address_id')->nullable()->constrained()->nullOnDelete('cascade');
            $table->string('discount_code')->nullable();
            $table->string('ref_id')->nullable();
            $table->string('currency')->default('LE');
            $table->double('total')->default(0.00);
            $table->double('sub_total')->default(0.00);
            $table->double('discount')->default(0.00);
            $table->double('shipping')->default(0.00);
            $table->unsignedTinyInteger('status')->default(1);
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
        Schema::dropIfExists('orders');
    }
};
