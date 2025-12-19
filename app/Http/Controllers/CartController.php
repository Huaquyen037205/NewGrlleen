<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Variants;

class CartController extends Controller
{
    public function index(){
        $cart = session()->get('cart', []);
        return view('page.cart', compact('cart'));
    }

    public function add(Request $request)
    {
       $variantId = $request->input('variant_id');
        $quantity = $request->input('quantity', 1);

        $variant = Variants::with('products.images')->find($variantId);
        if (!$variant) {
            return redirect()->back()->with('error', 'Biến thể không tồn tại!');
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$variantId])) {
            $cart[$variantId]['quantity'] += $quantity;
        } else {
            $cart[$variantId] = [
                'variant_id' => $variantId,
                'name' => $variant->products->name,
                'price' => $variant->sale_price ?: $variant->price,
                'image' => $variant->products->images->first()->name ?? 'default.jpg',
                'size' => $variant->size,
                'quantity' => $quantity,
            ];
        }

        session()->put('cart', $cart);
        return redirect()->route('cart.index')->with('success', 'Sản phẩm đã được thêm vào giỏ hàng!');
    }

    public function buyNow(Request $request)
    {
        $variantId = $request->input('variant_id');
        $quantity = $request->input('quantity', 1);

        $variant = Variants::with('products.images')->find($variantId);
        if (!$variant) {
            return redirect()->back()->with('error', 'Biến thể không tồn tại!');
        }

        $cart = [
            $variantId => [
                'variant_id' => $variantId,
                'name' => $variant->products->name,
                'price' => $variant->sale_price ?: $variant->price,
                'image' => $variant->products->images->first()->name ?? 'default.jpg',
                'size' => $variant->size,
                'quantity' => $quantity,
                'sale_price' => $variant->sale_price,
            ]
        ];

        session()->put('cart', $cart);

        return redirect()->route('payment');
    }

    public function update(Request $request)
    {
        $variantId = $request->input('variant_id');
        $quantity = (int) $request->input('quantity');

        $cart = session()->get('cart', []);

        if (isset($cart[$variantId])) {
            if ($quantity < 1) {
                unset($cart[$variantId]);
            } else {
                $cart[$variantId]['quantity'] = $quantity;
            }
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Giỏ hàng đã được cập nhật!');
    }

    public function remove(Request $request)
    {
        $variantId = $request->input('variant_id');

        $cart = session()->get('cart', []);

        if (!isset($cart[$variantId])) {
            return redirect()->route('cart.index')->with('error', 'Sản phẩm không tồn tại trong giỏ hàng!');
        }

        unset($cart[$variantId]);
        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng!');
    }

}
