<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->references('id')->on('products');
            $table->foreignId('img_id')->references('id')->on('products');
            $table->enum('size', ['50g', '100g', '150g', '200g'])->default('50g');
            $table->integer('stock_quantity')->default(0);
            $table->integer('price');
            $table->integer('sale_price')->nullable();
            $table->enum('status', ['còn hàng', 'hết hàng'])->default('còn hàng');
            $table->enum('active', ['on', 'off'])->default('on');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('variants');
    }
};
