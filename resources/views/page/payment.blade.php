@extends('template.user')
@section('content')
<style>
* {
    font-family: 'Poppins', sans-serif;
}

.payment {
    display: flex;
    justify-content: space-evenly;
}

.payment .title {
    text-align: center;
    margin: 10px 0;
    font-size: 24px;
}

.payment-infoUser {
    width: 45%;
    display: block;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 10px;
    background-color: #f9f9f9;
    box-shadow: 0 2px 6px rgba(0,0,0,0.12);
}

.input-box input {
    width: 100%;
    height: 50px;
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.input-box textarea {
    width: 100%;
    height: 120px;
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 5px;
    resize: none;
}

.payment-infoOder {
    width: 45%;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 10px;
    background-color: #f9f9f9;
    box-shadow: 0 2px 6px rgba(0,0,0,0.12);
}

.oder img {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 10px;
    margin-top: 5px;
}

.oder {
    display: flex;
}

.oder span {
    margin: 20px 0 0 20px;
    font-size: medium;
}

.btn-payment {
    display: flex;
    justify-content: space-between;
    margin: 20px 0 0 20px;
}

.btn-payment button {
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    background-color: #7cc652;
    color: white;
    cursor: pointer;
    font-size: 16px;
}

.btn-payment button:hover {
    background-color: #5aa32a;
}

.btn-payment a {
    text-decoration: none;
    color: #292e8a;
}

.btn-payment a:hover {
    text-decoration: underline;
}

.method {
  margin: 20px 0px 0px 25px;
}

.payment-method .desc {
  display: none;
  margin-left: 25px;
  padding: 15px 12px;
  background: #ffffff;
  border-left: 3px solid #7cc652;
  border-radius: 6px;
  font-size: 14px;
  color: #333333;
  box-shadow: 0 2px 6px rgba(0,0,0,0.12);
}

.method input[type="radio"]:checked + label + .desc {
  display: block;
}

.coupon-input {
  margin-top: 10px;
  padding: 15px;
  border: 1px dashed #ccc;
  border-radius: 8px;
  background: #fafafa;
}

.coupon-input p {
  margin-bottom: 10px;
  font-size: 15px;
}

.coupon-input input {
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 4px;
  margin-right: 8px;
}

.coupon-input button {
  background: #7cc652;
  color: white;
  border: none;
  padding: 8px 14px;
  border-radius: 4px;
  cursor: pointer;
}
</style>
<section>
        <div class="payment">
            <div class="payment-infoUser">
                <div class="title">
                    <p>Thông tin thanh toán</p>
                </div>
                <hr>
                @if ($errors->any())
                    <div style="color: red; margin-bottom: 10px;">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif
                <form action="{{ route('payment.cod') }}" method="POST">
                    @csrf
                    <div class="input-box">
                        <div class="input">
                            <input type="text" name="name" placeholder="Tên..." required>
                        </div>
                        <div class="input">
                            <input type="text" name="email" placeholder="Email..." required>
                        </div>
                    </div>

                    <div class="input-box">
                        <div class="input">
                            <input type="text" name="address" placeholder="Địa chỉ..." required value="{{ $address_text }}">
                                @if($address_text)
                                    <div style="color:#7cc652; font-size:13px; margin-top:2px;">
                                        (Địa chỉ mặc định của bạn)
                                    </div>
                                @endif
                        </div>
                        <div class="input">
                            <input type="text" name="phone" placeholder="Số điện thoại..." required>
                        </div>
                    </div>

                    <div class="input-box">
                        <div class="input">
                            <textarea name="note" id="" placeholder="Ghi chú đơn hàng..."></textarea>
                        </div>
                    </div>
            </div>

            <div class="payment-infoOder">
                <div class="title">
                    <p>Thông tin đơn hàng</p>
                </div>
                <hr>
                <div class="oder-box">
                    <div class="oder">
                        <span style="font-weight: 500;">Sản phẩm</span>
                    </div>
                    @foreach ($cart as $item)
                        <div class="oder">
                            <input type="hidden" name="cart[{{ $item['variant_id'] }}][name]" value="{{ $item['name'] }}">
                            <input type="hidden" name="cart[{{ $item['variant_id'] }}][size]" value="{{ $item['size'] }}">
                            <input type="hidden" name="cart[{{ $item['variant_id'] }}][quantity]" value="{{ $item['quantity'] }}">
                            <input type="hidden" name="cart[{{ $item['variant_id'] }}][price]" value="{{ $item['price'] }}">
                            @if(isset($item['sale_price']))
                                <input type="hidden" name="cart[{{ $item['variant_id'] }}][sale_price]" value="{{ $item['sale_price'] }}">
                            @endif

                            <img src="{{ asset('img/' . $item['image']) }}" alt="">
                            <span style="font-weight: 400;">{{ $item['name']}}</span>
                            <span style="font-weight: 400; color: rgb(147, 147, 147);">{{$item['size']}}</span>
                            <span style="font-weight: 400; color: rgb(147, 147, 147);">{{$item['quantity']}}</span>
                            @if (isset($item['sale_price']) && $item['sale_price'])
                                <span style="font-weight: 500; color: rgb(230 38 38 / var(--tw-text-opacity, 1)); text-decoration: line-through; font-size: smaller;">
                                    {{ number_format($item['sale_price']) }}₫
                                </span>
                            @else
                                <span style="font-weight: 500; color:#7cc652;">{{ number_format($item['price']) }}₫</span>
                            @endif
                        </div>
                        <hr style="margin: 10px 0; filter: blur(1px);">
                    @endforeach

                    @php
                        $total = collect($cart)->sum(function($i){ return (isset($i['sale_price']) && $i['sale_price']) ? $i['sale_price'] * $i['quantity'] : $i['price'] * $i['quantity']; });
                        $shipping = 30000;
                        $grandTotal = $total + $shipping;
                    @endphp
                    <input type="hidden" name="amount" value="{{ $grandTotal }}">
                    <div class="oder">
                        <span style="font-weight: 600;">Tạm tính:</span>
                        <span>{{ number_format($total, 0, ',', '.') }}₫</span>
                        <span style="font-weight: 600;">Phí vận chuyển:</span>
                        <span>{{ number_format($shipping, 0, ',', '.') }}₫</span>
                    </div>
                    <hr style="margin: 10px 0;">
                    <div class="oder">,
                        <span style="color: rgb(220 38 38 / var(--tw-text-opacity, 1)); font-size: larger; font-weight: 600;">Tổng đơn hàng:</span>
                        <span style="color: rgb(220 38 38 / var(--tw-text-opacity, 1)); font-size: larger; font-weight: 600;">{{ number_format($grandTotal, 0, ',', '.') }}₫</span>
                    </div>
                </div>

                <div class="coupon-input">
                    <p>
                    Có mã giảm giá?
                    <button id="toggle-coupon">Nhấn vào đây để nhập mã giảm giá</button>
                    </p>

                    <div class="coupon-input" id="coupon-box">
                    <input type="text" placeholder="Mã giảm giá...">
                    <button>Áp dụng</button>
                    </div>
                </div>

                <div class="payment-method">
                    <div class="method">
                        <span>Phương thức thanh toán:</span>
                    </div>
                    <div class="method">
                        <input type="radio" name="payment" id="cod" value="cod" checked>
                        <label for="cod">Thanh toán khi nhận hàng (COD)</label>
                        <div class="desc">
                            Bạn sẽ trả tiền mặt cho shipper khi nhận hàng.
                        </div>
                    </div>
                    <div class="method">
                        <input type="radio" name="payment" id="vnnpay" value="vnpay">
                        <label for="bank">Thanh toán VnPay</label>
                        <div class="desc">
                            Thanh toán nhanh chóng qua cổng VnPay.
                        </div>
                    </div>
                </div>
                <div class="btn-payment">
                    <a href="{{route('cart.index')}}"> < Quay lại giỏ hàng</a>
                    <button>Đặt hàng</button>
                </div>
                </form>
            </div>
        </div>
    </section>
<script>
document.getElementById("toggle-coupon").addEventListener("click", function() {
  const box = document.getElementById("coupon-box");
  box.style.display = (box.style.display === "block") ? "none" : "block";
});
</script>
@endsection
