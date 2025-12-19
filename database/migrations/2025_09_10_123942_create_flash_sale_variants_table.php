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
        Schema::create('flash_sale_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('flash_sale_id')->references('id')->on('flash_sales');
            $table->foreignId('variant_id')->references('id')->on('variants');
            $table->integer('flash_sale_price');
            $table->integer('quantity');
            $table->integer('sold')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flash_sale_variants');
    }
};
