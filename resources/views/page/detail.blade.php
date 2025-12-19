@extends('template.user')
@section('content')
<section>
    <div class="banner-page">
        <img src="/img/bg_breadcrumb.jpg" alt="">

        <div class="route-page">
            <div class="name-product">
                <h1 style="font-size: 35px; color:#5a4633 ">{{ $product->name }}</h1>
            </div>

            <div class="name-page">
                <p>Chi tiết sản phẩm</p> > <p>{{ $product->name }}</p>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="detail">
        <div class="detail-img">
            @if ($product->images->isNotEmpty())
                @foreach ($product->images as $image)
                    <img src="{{ asset('img/' . $image->name) }}" alt="{{ $product->name }}" width="300">
                @endforeach
            @else
                <img src="{{ asset('img/default.jpg') }}" alt="Default Image" width="300">
            @endif
        </div>

        <div class="detail-info">
            <div class="detail-name">
                <p style="font-size: 30px;">{{ $product->name }}</p>
            </div>

            <div class="status-detail">
                <p style="font-size: small;">Trạng thái: Còn hàng</p>
            </div>

            <div class="detail-price mb-3">
                <span id="price-area">
                    @php
                        $firstVariant = $product->variants->first();
                    @endphp
                    @if ($firstVariant && $firstVariant->sale_price)
                        <del style="color: #858585;">{{ number_format($firstVariant->price) }}₫</del>
                        <span style="color: #7cc652; font-weight: 700; font-size: 20px;">{{ number_format($firstVariant->sale_price) }}₫</span>
                    @elseif ($firstVariant)
                        <span style="color: #7cc652; font-weight: 700; font-size: 20px;">{{ number_format($firstVariant->price) }}₫</span>
                    @else
                        <span style="color: #7cc652; font-weight: 700; font-size: 20px;">{{ number_format($product->price) }}₫</span>
                    @endif
                </span>
            </div>

            {{-- <form action="{{ route('cart.add') }}" method="POST">
                @csrf
                <div class="detal-quantity">
                    <p style="font-size: small; font-weight: 600;"> Số lượng:</p>
                    <button type="button" onclick="decreaseQuantity()">-</button>
                    <input type="number" name="quantity" id="quantity" value="1" min="1">
                    <button type="button" onclick="increaseQuantity()">+</button>
                </div>
            </form> --}}

            <div class="decripstion">
                <p style="font-size: small;">{{ $product->description }}</p>
            </div>

            <div class="size mb-3">
                <p style="font-size: small; font-weight: 600;">Kích thước:</p>
                <div class="chosse">
                    @foreach ($product->variants as $variant)
                        <button type="button"
                            class="btn-size"
                            data-id="{{ $variant->id }}"
                            data-price="{{ $variant->price }}"
                            data-sale="{{ $variant->sale_price }}"
                            onclick="changePrice(this)">
                            {{ $variant->size }}
                        </button>
                    @endforeach
                </div>
            </div>

            <script>
           function changePrice(btn) {
                var price = btn.getAttribute('data-price');
                var sale = btn.getAttribute('data-sale');
                var variantId = btn.getAttribute('data-id');
                var priceArea = document.getElementById('price-area');
                document.getElementById('variant_id').value = variantId;
                document.getElementById('buy_variant_id').value = variantId;
                if (sale && sale !== 'null' && sale !== '') {
                    priceArea.innerHTML = `<del style="color: #858585;">${Number(price).toLocaleString()}₫</del>
                        <span style="color: #7cc652; font-weight: 700; font-size: 20px;">${Number(sale).toLocaleString()}₫</span>`;
                } else {
                    priceArea.innerHTML = `<span style="color: #7cc652; font-weight: 700; font-size: 20px;">${Number(price).toLocaleString()}₫</span>`;
                }
            }

            document.addEventListener('DOMContentLoaded', function() {
                var quantityInput = document.getElementById('quantity');
                var buyQuantityInput = document.getElementById('buy_quantity');

                function syncQuantity() {
                    buyQuantityInput.value = quantityInput.value;
                }

                quantityInput.addEventListener('input', syncQuantity);
                window.decreaseQuantity = function() {
                    var val = parseInt(quantityInput.value) || 1;
                    if (val > 1) quantityInput.value = val - 1;
                    syncQuantity();
                }
                window.increaseQuantity = function() {
                    var val = parseInt(quantityInput.value) || 1;
                    quantityInput.value = val + 1;
                    syncQuantity();
                }
            });
            </script>

                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="variant_id" id="variant_id" value="{{ $product->variants->first()->id }}">
                    <input type="hidden" name="name" value="{{ $product->name }}">
                    <div class="detal-quantity">
                        <p style="font-size: small; font-weight: 600;"> Số lượng:</p>
                        <button type="button" onclick="decreaseQuantity()">-</button>
                        <input type="number" name="quantity" id="quantity" value="1" min="1">
                        <button type="button" onclick="increaseQuantity()">+</button>
                    </div>
            <div class="btn-pay">
                    <div class="paymment-btn">
                        <button type="submit" class="btn-add-to-cart">Thêm vào giỏ hàng</button>
                    </div>
                </form>

                <form action="{{ route('cart.buyNow') }}" method="POST" style="display:inline;">
                    @csrf
                    <input type="hidden" name="variant_id" id="buy_variant_id" value="{{ $product->variants->first()->id }}">
                    <input type="hidden" name="name" value="{{ $product->name }}">
                    <input type="hidden" name="quantity" id="buy_quantity" value="1">
                    <div class="paymment-btn">
                        <button type="submit" class="btn-add-to-cart">Mua ngay</button>
                    </div>
                </form>
            </div>

            <div class="info-buy-product">
                <p style="font-size: small;">Gọi đặt mua: <a style="color: #7cc652; text-decoration: none;" href="">905.751.907</a> để đặt hàng nhanh chóng</p>
            </div>
        </div>
    </div>

    <div class="banner-slogan">
        <img src="/img/bg_pro.jpg" alt="">
    </div>
</section>
@endsection
