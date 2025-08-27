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
        Schema::create('variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->string('sku')->unique();
            $table->integer('quantity');
            $table->decimal('price');
            $table->foreignId('primary_attribute_id')->constrained('attributes')->nullOnDelete();
            $table->foreignId('primary_attribute_value_id')->constrained('attribute_values')->nullOnDelete();
            $table->foreignId('secondary_attribute_id')->nullable()->constrained('attributes')->nullOnDelete();
            $table->foreignId('secondary_attribute_value_id')->nullable()->constrained('attribute_values')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['product_id', 'sku']);
            $table->unique(['product_id', 'primary_attribute_id', 'primary_attribute_value_id', 'secondary_attribute_id', 'secondary_attribute_value_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('variants');
    }
};
