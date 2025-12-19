<?php

namespace App\Http\Controllers;
use App\Models\Products;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class MostViewController extends Controller
{
     public function search (Request $request){
        $keyword = $request->input('name');
        if ($keyword) {
            $products = Products::with('images', 'variants')
                ->where('name', 'LIKE', '%' . $keyword . '%')
                ->orWhere('description', 'LIKE', '%' . $keyword . '%')
                ->get();
                foreach ($products as $product) {
                $minPrice = $product->variants->min('price');
                $minSalePrice = $product->variants->whereNotNull('sale_price')->min('sale_price');
                $product->price = $minPrice;
                $product->sale_price = $minSalePrice ?: null;
        };
        } else {
            $products = Products::with('images', 'vatiants')->get();
            foreach ($products as $product) {
            $minPrice = $product->variants->min('price');
            $minSalePrice = $product->variants->whereNotNull('sale_price')->min('sale_price');
            $product->price = $minPrice;
            $product->sale_price = $minSalePrice ?: null;
        };
        }
    return view('page.home', ['products' => $products, 'keyword' => $keyword]);
    }
}
