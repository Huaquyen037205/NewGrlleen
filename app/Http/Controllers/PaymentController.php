<?php

namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\Order_item;
use App\Models\Address;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function payment()
    {
        $cart = session()->get('cart', []);
        $address = Address::where('user_id', auth()->id())->where('is_default', 1)->first();
        $address_text = $address ? $address->address : '';
        return view('page.payment', compact('cart', 'address_text', ));
    }

    public function paymentSuccess()
    {
        return view('payment.success');
    }

    public function CodPay(Request $request)
    {
         $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'address' => 'required|string|max:255',
            'phone'   => 'required|string|max:20',
            'payment' => 'required|in:cod,vnpay',
        ], [
            'required' => 'Vui lòng nhập :attribute.',
            'email'    => 'Email không hợp lệ.',
        ], [
            'name'    => 'họ tên',
            'email'   => 'email',
            'address' => 'địa chỉ',
            'phone'   => 'số điện thoại',
            'payment' => 'phương thức t h toán',
        ]);

        $cart = $request->input('cart', []);
        $amount = $request->input('amount', 0);
        $userId = auth()->id() ?? 1;

        $address = Address::where('user_id', $userId)->where('is_default', 1)->first();
        if (!$address && $request->filled('address')) {
            $address = Address::create([
                'user_id'   => $userId,
                'address'   => $request->address,
                'is_default'=> 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        $address_id = $address ? $address->id : null;
        $address_text = $address ? $address->address : $request->address;

        if ($request->payment == 'cod') {
            $orderId = DB::table('orders')->insertGetId([
                'user_id' => auth()->id() ?? 1,
                'payment_id' => 1,
                'shipping_id' => 1,
                'address_id' => $address_id,
                'total_amount' => $amount,
                'status' => 'pending',
                'order_code' => 'COD' . time(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            foreach ($cart as $variantId => $item) {
                DB::table('order_items')->insert([
                    'order_id' => $orderId,
                    'variant_id' => $variantId,
                    'quantity' => $item['quantity'],
                    'price' => isset($item['sale_price']) && $item['sale_price'] ? $item['sale_price'] : $item['price'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $variant = DB::table('variants')->where('id', $variantId)->first();
                    if ($variant) {
                        DB::table('products')->where('id', $variant->product_id)->increment('hot', $item['quantity']);
                    }
            }

            session()->forget('cart');
            return view('payment.success');
        } else {
            session([
                'order_info' => [
                    'name' => $request->name,
                    'email' => $request->email,
                    'address' => $request->address,
                    'phone' => $request->phone,
                    'note' => $request->note,
                    'cart' => $cart,
                    'amount' => $amount,
                ]
            ]);

            return $this->createVnPay($request);
        }

    }

    public function createVnPay(Request $request)
    {

        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'address' => 'required|string|max:255',
            'phone'   => 'required|string|max:20',
        ], [
            'required' => 'Vui lòng nhập :attribute.',
            'email'    => 'Email không hợp lệ.',
        ], [
            'name'    => 'họ tên',
            'email'   => 'email',
            'address' => 'địa chỉ',
            'phone'   => 'số điện thoại',
        ]);

        $name = $request->input('name');
        $email = $request->input('email');
        $address = $request->input('address');
        $phone = $request->input('phone');
        $note = $request->input('note');
        $cart = $request->input('cart', []);
        $amount = $request->input('amount', 0);

        // Thông tin cấu hình VnPay
        $vnp_TmnCode = env('VNP_TMN_CODE');
        $vnp_HashSecret = env('VNP_HASH_SECRET');
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = route('payment.vnpay.callback');

        $vnp_TxnRef = time();
        $vnp_OrderInfo = "Thanh toán đơn hàng";
        $vnp_OrderType = "billpayment";
        $vnp_Amount = $request->input('amount', 100000) * 100;
        $vnp_Locale = "vn";
        $vnp_BankCode = $request->input('bank_code', '');
        $vnp_IpAddr = $request->ip();

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );
        if ($vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        ksort($inputData);
        $query = [];
        foreach ($inputData as $key => $value) {
            $query[] = urlencode($key) . "=" . urlencode($value);
        }
        $hashdata = implode('&', $query);

        $vnp_Url .= "?" . implode('&', $query);
        $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
        $vnp_Url .= '&vnp_SecureHash=' . $vnpSecureHash;

            session([
            'order_info' => [
                'name' => $name,
                'email' => $email,
                'address' => $address,
                'phone' => $phone,
                'note' => $note,
                'cart' => $cart,
                'amount' => $amount,
            ]
        ]);

        return redirect($vnp_Url);
    }

    public function vnpayCallback(Request $request)
    {
        $vnp_ResponseCode = $request->input('vnp_ResponseCode');
        $orderInfo = session('order_info');
        $cart = $orderInfo['cart'] ?? [];
        $amount = $orderInfo['amount'] ?? 0;
        $userId = auth()->id() ?? 1;

        $address = Address::where('user_id', $userId)->where('is_default', 1)->first();
        if (!$address && $request->filled('address')) {
            $address = Address::create([
                'user_id'   => $userId,
                'address'   => $request->address,
                'is_default'=> 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        $address_id = $address ? $address->id : null;
        $address_text = $address ? $address->address : ($orderInfo['address'] ?? '');

        if ($vnp_ResponseCode == '00') {
            $orderId = DB::table('orders')->insertGetId([
            'user_id' => auth()->id() ?? 1,
            'payment_id' => 2,
            'shipping_id' => 1,
            'address_id' => $address_id,
            // 'address' => $address_text,
            'total_amount' => $amount,
            'status' => 'pending',
            'order_code' => 'VnPay' . time(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        foreach ($cart as $variantId => $item) {
            DB::table('order_items')->insert([
                'order_id' => $orderId,
                'variant_id' => $variantId,
                'quantity' => $item['quantity'],
                'price' => isset($item['sale_price']) && $item['sale_price'] ? $item['sale_price'] : $item['price'],
                'created_at' => now(),
                'updated_at' => now(),
                ]);

                $variant = DB::table('variants')->where('id', $variantId)->first();
                    if ($variant) {
                        DB::table('products')->where('id', $variant->product_id)->increment('hot', $item['quantity']);
                    }
            }
        }

        session()->forget('cart');
        session()->forget('order_info');
        return view('payment.success');
    }

    public function orderList()
    {
        $orders = DB::table('orders')
            ->leftJoin('payments', 'orders.payment_id', '=', 'payments.id')
            ->select('orders.*', 'payments.payment_method as payment_method', 'payments.payment_status as payment_status')
            ->where('orders.user_id', auth()->id())
            ->orderByDesc('orders.created_at')
            ->get();

        return view('profile.orderList', compact('orders'));
    }

    public function orderDetail($orderId)
    {
        $order = DB::table('orders')
        ->where('id', $orderId)
        ->where('user_id', auth()->id())
        ->first();
        if (!$order) abort(404);

        $items = DB::table('order_items')
            ->join('variants', 'order_items.variant_id', '=', 'variants.id')
            ->join('products', 'variants.product_id', '=', 'products.id')
            ->leftJoin('images', function($join) {
                $join->on('products.id', '=', 'images.product_id');
            })
            ->select(
                'order_items.*',
                'products.name as product_name',
                'variants.size',
                'images.name as image'
            )
            ->where('order_id', $orderId)
            ->get();
            $shipping_fee = 30000;
        return view('profile.orderDetail', compact('order', 'items', 'shipping_fee'));
    }
}
