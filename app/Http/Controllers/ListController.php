<?php

namespace App\Http\Controllers;
use App\Models\Products;
use App\Models\Categories;
use App\Models\Images;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class ListController extends Controller
{
       public function search(Request $request)
    {
        $q = $request->input('q');

        $products = Products::when($q, function ($query, $q) {
            return $query->where('name', 'like', "%{$q}%");
        })->orderByDesc('hot')->paginate(15);

        $categories = Categories::all();

        return view('admin.dashboard', compact('products', 'categories', 'q'));
    }

    public function dashboard()
    {
        $products = Products::orderByDesc('hot')->paginate(15);
            $categories = Categories::all();
            $q = null;

            $ordersCount = DB::table('orders')->where('status', 'paid')->count();
            $usersCount = DB::table('users')->count();

            if (Schema::hasColumn('orders', 'shipping_fee') && Schema::hasColumn('orders', 'status')) {
                $revenue = (float) DB::table('orders')
                    ->where('status', 'paid')
                    ->select(DB::raw('IFNULL(SUM(total_amount - COALESCE(shipping_fee,0)),0) as revenue'))
                    ->value('revenue');

                $shippingFeeTotal = (float) DB::table('orders')
                    ->where('status', 'paid')
                    ->select(DB::raw('IFNULL(SUM(COALESCE(shipping_fee,0)),0) as ship'))
                    ->value('ship');
            } else {
                $defaultShip = config('shop.shipping_fee', 30000);

                $sumTotal = (float) DB::table('orders')
                    ->where('status', 'paid')
                    ->select(DB::raw('IFNULL(SUM(total_amount),0) as s'))
                    ->value('s');

                $shippingFeeTotal = $ordersCount * $defaultShip;
                $revenue = $sumTotal - $shippingFeeTotal;

                $monthlyRevenueRaw = DB::table('orders')
                    ->where('status', 'paid')
                    ->select(
                        DB::raw('MONTH(created_at) as month'),
                        DB::raw("SUM(total_amount - $defaultShip) as revenue")
                    )
                    ->whereYear('created_at', date('Y'))
                    ->groupBy('month')
                    ->pluck('revenue', 'month')
                    ->toArray();
            }

            $ordersByMonthRaw = DB::table('orders')
                ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as cnt'))
                ->whereYear('created_at', date('Y'))
                ->groupBy('month')
                ->pluck('cnt', 'month')
                ->toArray();

            $monthlyRevenue = [];
            $monthlyOrders = [];
            for ($m = 1; $m <= 12; $m++) {
                $monthlyRevenue[] = isset($monthlyRevenueRaw[$m]) ? (float)$monthlyRevenueRaw[$m] : 0;
                $monthlyOrders[] = isset($ordersByMonthRaw[$m]) ? (int)$ordersByMonthRaw[$m] : 0;
            }

            $topProductsRaw = DB::table('order_items')
                ->join('variants', 'order_items.variant_id', '=', 'variants.id')
                ->join('products', 'variants.product_id', '=', 'products.id')
                ->select('products.name', DB::raw('SUM(order_items.quantity) as total_qty'))
                ->groupBy('products.name')
                ->orderByDesc('total_qty')
                ->limit(5)
                ->get();

            $productLabels = $topProductsRaw->pluck('name')->toArray();
            $productValues = $topProductsRaw->pluck('total_qty')->toArray();

            $ordersToday = Order::with('user', 'shipping', 'payment')
                ->whereDate('created_at', now()->startOfDay())
                ->orderByDesc('created_at')
                ->paginate(8);

            $recentOrders = DB::table('orders')->orderByDesc('created_at')->limit(5)->get();

            return view('admin.dashboard', compact(
                'products',
                'categories',
                'q',
                'revenue',
                'ordersCount',
                'usersCount',
                'shippingFeeTotal',
                'recentOrders',
                'monthlyRevenue',
                'monthlyOrders',
                'productLabels',
                'productValues',
                'ordersToday'
            ));
    }


    public function dashboardUser(Request $request)
    {
        $role = $request->input('role');
        $status = $request->input('status');
        $roles = User::select('role')->distinct()->pluck('role')->filter()->values();
        $statuses = User::select('is_active')->distinct()->pluck('is_active')->filter()->values();
        $totalUsers = User::when($role, fn($q,$r) => $q->where('role', $r))
                        ->when($status, fn($q,$s) => $q->where('is_active', $s))
                        ->count();

        $newUsers = User::when($role, fn($q,$r) => $q->where('role', $r))
                        ->when($status, fn($q,$s) => $q->where('is_active', $s))
                        ->where('created_at', '>=', Carbon::now()->subMonth())->count();

        $activeUsers = User::when($role, fn($q,$r) => $q->where('role', $r))
                        ->when($status, fn($q,$s) => $q->where('is_active', $s))
                        ->where('is_active', 'active')->count();

        $inactiveUsers = User::when($role, fn($q,$r) => $q->where('role', $r))
                            ->when($status, fn($q,$s) => $q->where('is_active', $s))
                            ->where('is_active', 'inactive')->count();

        $users = User::when($role, fn($q,$r) => $q->where('role', $r))
                    ->when($status, fn($q,$s) => $q->where('is_active', $s))
                    ->orderByDesc('created_at')
                    ->paginate(15)
                    ->withQueryString();

        return view('admin.user', compact('users', 'totalUsers', 'newUsers', 'activeUsers', 'inactiveUsers', 'roles', 'role','statuses','status'));
    }

    public function editRoleUser(Request $request, $id)
    {
        $data = $request->validate([
            'role' => 'required|in:admin,user'
        ]);

        $user = User::find($id);
        if (!$user) {
            return redirect()->route('admin.user')->with('error', 'Người dùng không tồn tại.');
        }

        $user->role = $data['role'];
        $user->save();

        return redirect()->route('admin.user')->with('success', 'Đã chỉnh sửa vai trò người dùng thành công.');
    }

    public function editActiveUser(Request $request, $id)
    {
        $data = $request->validate([
            'is_active' => 'required|in:active,inactive'
        ]);

        $user = User::find($id);
        if (!$user) {
            return redirect()->route('admin.user')->with('error', 'Người dùng không tồn tại.');
        }

        $user->is_active = $data['is_active'];
        $user->save();

        return redirect()->route('admin.user')->with('success', 'Đã chỉnh sửa trạng thái người dùng thành công.');
    }

    public function dashboardProduct(Request $request)
    {
        $q = $request->input('q');
        $categoryId = $request->input('category_id');
        $status = $request->input('status');

        $totalProducts = Products::count();
        $newProducts = Products::where('created_at', '>=', Carbon::now()->subMonth())->count();
        $outOfStock = Products::where('status', 'hết hàng')->count();
        $activeProducts = Products::where('status', 'còn hàng')->count();

        $categories = Categories::all();
        $products = Products::with('images', 'variants', 'category')
        ->when($categoryId, fn($query) => $query->where('category_id', $categoryId))
        ->when($status, fn($query) => $query->where('status', $status))
        ->orderBy('created_at', 'desc')
        ->paginate(8)
        ->appends($request->query());
        return view('admin.product', compact('products', 'categories', 'totalProducts', 'newProducts', 'outOfStock', 'activeProducts', 'q', 'categoryId', 'status'));
    }

    public function searchProduct(Request $request)
    {
        $q = $request->input('q');

        $products = Products::with('images', 'variants', 'category')
        ->when($q, function ($query, $q) {
            return $query->where('name', 'like', "%{$q}%");
        })->orderByDesc('created_at')->paginate(8);

        $totalProducts = Products::count();
        $newProducts = Products::where('created_at', '>=', Carbon::now()->subMonth())->count();
        $outOfStock = Products::where('status', 'hết hàng')->count();
        $activeProducts = Products::where('status', 'còn hàng')->count();
        $categoryId = $request->input('category_id');
        $status = $request->input('status');

        $categories = Categories::all();

        return view('admin.product', compact('products', 'categories', 'q', 'totalProducts', 'newProducts', 'outOfStock', 'activeProducts', 'categoryId', 'status'));
    }

    public function addProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'origin' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:còn hàng,hết hàng',
            'active' => 'required|in:đang bán,ngừng bán',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpg,jpeg,png,gif,webp|max:5120'
        ]);

        $product = Products::create([
        'name' => $request->name,
        'description' => $request->description,
        'origin' => $request->origin,
        'category_id' => $request->category_id,
        'status' => $request->status,
        'active' => $request->active,
    ]);

    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $ext = $image->getClientOriginalExtension();
            $filename = time() . '_' . uniqid() . '.' . $ext;
            $image->move(public_path('img'), $filename);

            if (method_exists($product, 'images')) {
                $product->images()->create([
                    'name' =>  $filename,
                ]);
            } else {
                Images::create([
                    'product_id' => $product->id,
                    'name' =>  $filename,
                ]);
            }
        }
    }

    return redirect()->route('admin.products.list')->with('success', 'Thêm sản phẩm mới thành công!');
    }

    public function editProduct(Request $request, $id)
    {
        $product = Products::find($id);
        if (!$product) {
            return redirect()->route('admin.products.list')->with('error', 'Sản phẩm không tồn tại.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'origin' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:còn hàng,hết hàng',
            'active' => 'required|in:đang bán,ngừng bán',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpg,jpeg,png,gif,webp|max:5120'
        ]);

        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'origin' => $request->origin,
            'category_id' => $request->category_id,
            'status' => $request->status,
            'active' => $request->active,
        ]);

        if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $ext = $image->getClientOriginalExtension();
            $filename = time() . '_' . uniqid() . '.' . $ext;
            $image->move(public_path('img'), $filename);

            if (method_exists($product, 'images')) {
                $product->images()->create([
                    'name' =>  $filename,
                ]);
            } else {
                Images::create([
                    'product_id' => $product->id,
                    'name' =>  $filename,
                ]);
            }
        }
    }

        return redirect()->route('admin.products.list')->with('success', 'Chỉnh sửa sản phẩm thành công!');
    }

    public function productDetail($id)
    {
        $variants = DB::table('variants')->where('product_id', $id)->get();
        $totalVariants = $variants->sum('stock_quantity');
        $outOfStockCount = $variants->where('stock_quantity', 0)->count();
        $product = Products::with('images', 'category', )->find($id);
        if (!$product) {
            return redirect()->route('admin.products.list')->with('error', 'Sản phẩm không tồn tại.');
        }

        return view('admin.productDetail', compact('product', 'variants', 'totalVariants', 'outOfStockCount'));
    }

    public function addVariant(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'size' => 'required|string|max:50',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'status' => 'required|in:còn hàng,hết hàng',
            'active' => 'required|in:on,off',
        ]);
        $img = Images::where('product_id', $request->product_id)->first();
        $imgId = $img ? $img->id : null;

        DB::table('variants')->insert([
            'product_id' => $request->product_id,
            'size' => $request->size,
            'price' => $request->price,
            'sale_price' => $request->sale_price,
            'status' => $request->status,
            'active' => $request->active,
            'stock_quantity' => $request->stock_quantity,
            'img_id' => $imgId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.productDetail', ['id' => $request->product_id])->with('success', 'Thêm biến thể sản phẩm thành công!');
    }

    public function editVariant(Request $request, $id)
    {
        $variant = DB::table('variants')->where('id', $id)->first();
        if (!$variant) {
            return redirect()->back()->with('error', 'Biến thể không tồn tại.');
        }

        $request->validate([
            'size' => 'required|string|max:50',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'status' => 'required|in:còn hàng,hết hàng',
            'active' => 'required|in:on,off',
        ]);

        DB::table('variants')->where('id', $id)->update([
            'size' => $request->size,
            'price' => $request->price,
            'sale_price' => $request->sale_price,
            'status' => $request->status,
            'active' => $request->active,
            'stock_quantity' => $request->stock_quantity,
            'updated_at' => now(),
        ]);

        return redirect() ->route('admin.productDetail', ['id' => $variant->product_id])->with('success', 'Chỉnh sửa sản phẩm thành công!');
    }

    public function categoryDasboard(Request $request)
    {
        $q = $request->input('q');
        $status = $request->input('status');

        $categories = Categories::withCount('products')
        ->when($q, function ($query, $q) {
            return $query->where('name', 'like', "%{$q}%");
        })
        ->when($status, function ($query, $status) {
            return $query->where('status', $status);
        })
        ->orderByDesc('created_at')
        ->paginate(10);

        $totalCategories = Categories::count();
        $activeCategories = Categories::where('status', 'active')->count();
        $hiddenCategories = Categories::where('status', 'inactive')->count();

        return view('admin.Category', compact('categories', 'q', 'totalCategories', 'activeCategories', 'hiddenCategories', 'status'));
    }

    public function addCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'status' => 'required|in:active,inactive',
        ]);

        Categories::create([
            'name' => $request->name,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.category.list')->with('success', 'Thêm danh mục mới thành công!');
    }

    public function editCategory(Request $request, $id)
    {
        $category = Categories::find($id);
        if (!$category) {
            return redirect()->route('admin.categories.list')->with('error', 'Danh mục không tồn tại.');
        }

        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $id,
        ]);

        $category->update([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.category.list')->with('success', 'Chỉnh sửa danh mục thành công!');
    }

    public function editCategoryStatus($id)
    {
        $category = Categories::findOrFail($id);

        $category->status = $category->status === 'active' ? 'inactive' : 'active';
        $category->save();

        return redirect()->back()->with('success', 'Cập nhật trạng thái danh mục thành công!');
    }

    public function orderDasboard(Request $request)
    {
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $processingOrders = Order::where('status', 'processing')->count();
        $completedOrders = Order::where('status', 'paid')->count();
        $cancelledOrders = Order::where('status', 'cancelled')->count();
        $status = $request->input('status');

        $orders = Order::with('user', 'shipping', 'payment')
        ->when($status, fn($q) => $q->where('status', $status))
        ->orderByDesc('created_at')
        ->paginate(15)
        ->withQueryString();
        return view('admin.order', compact('orders', 'status', 'totalOrders', 'pendingOrders', 'processingOrders', 'completedOrders', 'cancelledOrders'));
    }

    public function orderDetail($id)
    {
        $order = Order::with([
            'user',
            'address',
            'payment',
            'orderItems.variant.products.images',
            'orderItems.variant.products.images',
        ])->find($id);

        if (!$order) {
            return redirect()->route('admin.orders.list')->with('error', 'Đơn hàng không tồn tại.');
        }

        return view('admin.orderDetail', compact('order'));
    }

    public function editOrderStatus(Request $request, $id)
    {
        $order = Order::find($id);
        if (!$order) {
            return redirect()->route('admin.orders.list')->with('error', 'Đơn hàng không tồn tại.');
        }

        $request->validate([
            'status' => 'required|in:pending,processing,paid,cancelled',
        ]);

        $allowedTransitions = [
            'pending'    => ['processing', 'cancelled'],
            'processing' => ['paid', 'cancelled'],
            'paid'       => [],
            'cancelled'  => [],
        ];

        $current = $order->status;
        $target = $request->status;

        if ($target === $current) {
            return redirect()->route('admin.orderDetail', ['id' => $id])->with('info', 'Trạng thái không thay đổi.');
        }

        if (!in_array($target, $allowedTransitions[$current] ?? [])) {
            return redirect()->route('admin.orderDetail', ['id' => $id])
                ->with('error', "Không thể chuyển trạng thái từ '{$current}' sang '{$target}'.");
        }

        $order->status = $target;
        $order->save();

        return redirect()->route('admin.orderDetail', ['id' => $id])->with('success', 'Cập nhật trạng thái đơn hàng thành công!');
    }
}
