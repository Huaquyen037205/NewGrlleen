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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users');
            $table->foreignId('payment_id')->references('id')->on('payments');
            $table->foreignId('shipping_id')->references('id')->on('shippings');
            $table->foreignId('coupon_id')->nullable()->references('id')->on('coupons');
            $table->foreignId('discount_id')->nullable()->references('id')->on('discounts');
            $table->foreignId('address_id')->references('id')->on('addresses');
            $table->integer('total_amount');
            $table->enum('status', ['pending', 'processing', 'paid', 'cancelled'])->default('pending');
            $table->string('order_code');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
