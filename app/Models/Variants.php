<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Variants extends Model
{
    protected $fillable = [
        'product_id','img_id' ,'size', 'price', 'sale_price', 'stock_quantity', 'status', 'active'
    ];
    public function products()
    {
        return $this->belongsTo(Products::class, 'product_id', 'id');
    }

    public function order_items()
    {
        return $this->hasMany(OrderItems::class, 'variant_id', 'id');
    }

    public function images()
    {
        return $this->belongsTo(Images::class, 'img_id', 'id');
    }

    public function getImageUrlAttribute()
    {
        $img = optional(optional($this->products)->images->first());
        $name = optional($img)->name;
        return $name ? asset('img/' . $name) : asset('img/default.jpg');
    }

}
