<?php
namespace App\Http\Controllers;
use App\Models\Products;
use App\Models\Categories;
use App\Models\Variants;
use App\Models\Address;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home(Request $request)
    {
        $products = Products::with(['images', 'variants'])->paginate(10);
        foreach ($products as $product) {
            $minPrice = $product->variants->min('price');
            $minSalePrice = $product->variants->whereNotNull('sale_price')->min('sale_price');
            $product->price = $minPrice;
            $product->sale_price = $minSalePrice ?: null;
        };

        $hotProducts = Products::with(['images', 'variants'])
        ->where('hot', '>', 0)
        ->orderByDesc('hot')
        ->take(8)
        ->get();

        foreach ($hotProducts as $product) {
            $minPrice = $product->variants->min('price');
            $minSalePrice = $product->variants->whereNotNull('sale_price')->min('sale_price');
            $product->price = $minPrice;
            $product->sale_price = $minSalePrice ?: null;
        }


        if ($request->ajax()) {
            return view('page.partials.product_list', compact('products'))->render();
        }

        $data = [
            'products' => $products,
            'hotProducts' => $hotProducts,

        ];
        return view('page.home', $data);
    }

    public function category($id, Request $request)
    {
        $category = Categories::find($id);
        if (!$category) {
            return redirect()->route('home')->with('error', 'Category not found.');
        }

        $products = Products::with(['images', 'variants'])
            ->where('category_id', $id)
            ->paginate(10);

        foreach ($products as $product) {
            $minPrice = $product->variants->min('price');
            $minSalePrice = $product->variants->whereNotNull('sale_price')->min('sale_price');
            $product->price = $minPrice;
            $product->sale_price = $minSalePrice ?: null;
        };

        return view('page.home', ['products' => $products, 'category' => $category]);
    }

    public function address()
    {
        $addresses = DB::table('addresses')->where('user_id', auth()->id())->get();
        $order = DB::table('orders')
        ->where('user_id', auth()->id())
        ->orderByDesc('created_at')
        ->first();
        return view('profile.address', compact('addresses', 'order'));
    }

    public function newAddress(Request $request){
        $request->validate([
            'address' => 'required|string|max:255',
        ]);

        Address::create([
            'user_id' => auth()->id(),
            'address' => $request->address,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return redirect()->back()->with('success', 'Đã thêm địa chỉ mới!');
    }

    public function setDefaultAddress($id)
    {
        $userId = auth()->id();
        Address::where('user_id', $userId)->update(['is_default' => 0]);
        Address::where('user_id', $userId)->where('id', $id)->update(['is_default' => 1]);
        return redirect()->back()->with('success', 'Đã đặt địa chỉ mặc định!');
    }

    public function contact()
    {
        return view('page.contact');
    }

    public function account()
    {
        $user = auth()->user()->load('address');
        return view('profile.infoAccount', compact('user'));
    }
}
