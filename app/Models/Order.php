<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'payment_id',
        'shipping_id',
        'coupon_id',
        'discount_id',
        'address_id',
        'total_amount',
        'status',
        'order_code',
        'created_at',
        'updated_at'
    ];

    public function items()
    {
        return $this->hasMany(Order_item::class, 'order_id');
    }

        public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

     public function shipping()
    {
        return $this->belongsTo(Shipping::class, 'shipping_id', 'id');
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_id', 'id');
    }

    public function discount()
    {
        return $this->belongsTo(Discount::class, 'discount_id', 'id');
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class, 'coupon_id', 'id');
    }

    public function address()
    {
        return $this->belongsTo(Address::class, 'address_id', 'id');
    }

    public function orderItems()
    {
        return $this->hasMany(\App\Models\Order_item::class, 'order_id', 'id');
    }
}
