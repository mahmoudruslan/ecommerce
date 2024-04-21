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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId( 'user_id' )->nullable()->constrained()->onDelete('cascade');
            $table->foreignId( 'product_id' )->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('email');
            $table->string('title');
            $table->text('body');
            $table->boolean('status')->default(0); 
            $table->unsignedTinyInteger('rating')->default(1);
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
        Schema::dropIfExists('reviews');
    }
};
