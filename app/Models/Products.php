<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'discount_id', 'name', 'description', 'status', 'active', 'hot', 'origin'
    ];

    public function images()
    {
       return $this->hasMany(Images::class,'product_id','id');
    }

    public function category()
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }

    public function variants()
{
    return $this->hasMany(Variants::class, 'product_id', 'id');
}
}
