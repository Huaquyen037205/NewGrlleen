@extends('template.user')
@section('content')

<section>
    <style>
        .cart-container {
            max-width: 900px;
            margin: 40px auto;
            padding: 25px;
            background-color: #f5f5ef;
            border-radius: 16px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.08);
            font-family: 'Open Sans', sans-serif;
            border: 1px solid #d4e4d2;
        }

        .cart-header {
            text-align: center;
            font-size: 30px;
            font-weight: normal;
            color: #2c4a3b;
            margin-bottom: 25px;
            letter-spacing: 1px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #e0e8d9;
        }

        th {
            background-color: #e8f0e3;
            font-weight: normal;
            color: #3a5f4a;
            text-transform: uppercase;
            font-size: 13px;
            letter-spacing: 0.5px;
        }

        td {
            color: #333;
            font-size: 15px;
        }

        .product-image {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 10px;
            border: 1px solid #e0e8d9;
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-decrease, .btn-increase, .btn-remove {
            padding: 8px 14px;
            border: none;
            cursor: pointer;
            border-radius: 10px;
            font-size: 15px;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .btn-decrease {
            background-color: #b8d4a6;
            color: #2c4a3b;
        }

        .btn-decrease:hover {
            background-color: #a3c292;
            transform: scale(1.05);
        }

        .btn-increase {
            background-color: #7aa874;
            color: white;
        }

        .btn-increase:hover {
            background-color: #689765;
            transform: scale(1.05);
        }

        .btn-remove {
            background-color: #d99f9f;
            color: white;
        }

        .btn-remove:hover {
            background-color: #c88b8b;
            transform: scale(1.05);
        }

        .price {
            color: #6b8e23;
            font-weight: 600;
        }

        .total-price {
            color: #a0522d;
            font-weight: 600;
        }

        .empty-cart {
            text-align: center;
            padding: 60px 20px;
            color: #5a7a5e;
            font-size: 17px;
            background-color: #f9f9f4;
            font-family: 'Open Sans', sans-serif;
            border-radius: 10px;
            border: 1px solid #e0e8d9;
        }

        .cart-total {
            text-align: right;
            font-size: larger;
            font-weight: 600;
            color: #e33f19;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 2px solid #e0e8d9;
        }

        .btn-cart {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .checkout-btn {
            display: block;
            width: 220px;
            margin: 25px auto;
            padding: 14px 20px;
            background-color: #6b8e23;
            color: white;
            text-align: center;
            border-radius: 12px;
            font-size: 16px;
            text-decoration: none;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .checkout-btn:hover {
            background-color: #5a7a1e;
            transform: scale(1.03);
        }

        @media (max-width: 768px) {
            .cart-container {
                padding: 15px;
                margin: 20px;
            }

            th, td {
                padding: 10px;
                font-size: 13px;
            }

            .product-image {
                width: 50px;
                height: 50px;
            }

            .quantity-controls {
                flex-direction: column;
                gap: 6px;
            }

            .btn-decrease, .btn-increase, .btn-remove {
                width: 100%;
                padding: 10px;
            }

            .cart-header {
                font-size: 24px;
            }
        }
    </style>

    <div class="cart-container">
        <h1 class="cart-header">Giỏ hàng</h1>

        @if (!isset($cart) || count($cart) === 0)
            <div class="empty-cart">
                <p>Giỏ hàng của bạn đang trống.</p>
                <a href="{{ route('home') }}" class="checkout-btn" style="background-color: #8a9a7b;">Tiếp tục mua sắm</a>
            </div>
        @else
            @php $total = 0; @endphp
            <table>
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Tên sản phẩm</th>
                        <th>Giá</th>
                        <th>Kích cỡ</th>
                        <th>Số lượng</th>
                        <th>Tổng tiền</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cart as $item)
                        @php $total += $item['price'] * $item['quantity']; @endphp
                        <tr>
                            <td><img src="{{ asset('img/' . $item['image']) }}" alt="{{ $item['name'] }}" class="product-image"></td>
                            <td>{{ $item['name'] }}</td>
                            <td class="price">{{ number_format($item['price']) }}₫</td>
                            <td>{{ $item['size'] }}</td>
                            <td>
                                <div class="quantity-controls">
                                    <form action="{{ route('cart.update') }}" method="POST" style="display: inline;">
                                        @csrf
                                        <input type="hidden" name="variant_id" value="{{ $item['variant_id'] }}">
                                        <input type="hidden" name="quantity" value="{{ $item['quantity'] - 1 }}">
                                        <button type="submit" class="btn-decrease" onclick="return confirm('Giảm số lượng?')">−</button>
                                    </form>
                                    <span>{{ $item['quantity'] }}</span>
                                    <form action="{{ route('cart.update') }}" method="POST" style="display: inline;">
                                        @csrf
                                        <input type="hidden" name="variant_id" value="{{ $item['variant_id'] }}">
                                        <input type="hidden" name="quantity" value="{{ $item['quantity'] + 1 }}">
                                        <button type="submit" class="btn-increase">＋</button>
                                    </form>
                                </div>
                            </td>
                            <td class="total-price">{{ number_format($item['price'] * $item['quantity']) }}₫</td>
                            <td>
                                <form action="{{ route('cart.remove') }}" method="POST" style="display: inline;">
                                    @csrf
                                    <input type="hidden" name="variant_id" value="{{ $item['variant_id'] }}">
                                    <button type="submit" class="btn-remove" onclick="return confirm('Xóa sản phẩm này?')">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="cart-total">
                Tổng cộng: {{ number_format($total) }}₫
            </div>
            <div class="btn-cart">
                <a href="{{ route('home') }}" class="checkout-btn">Tiếp tục mua hàng</a>
                <a href="{{ route('payment') }}" class="checkout-btn">Thanh toán</a>
            </div>

        @endif
    </div>
</section>

@endsection
