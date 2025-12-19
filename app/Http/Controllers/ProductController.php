<?php

namespace App\Http\Controllers;
use App\Models\Products;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function detail($id){
        $product = Products::with(['images', 'variants'])->findOrFail($id);
        $minPrice = $product->variants->min('price');
        $minSalePrice = $product->variants->whereNotNull('sale_price')->min('sale_price');
        $product->price = $minPrice;
        $product->sale_price = $minSalePrice ?: null;
        return view('page.detail', ['product' => $product]);
    }
}
