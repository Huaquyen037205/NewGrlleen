@extends('template.user')
@section('content')
<section>
    <div class="banner">
        <div class="slider">
            <div class="slide"><img src="/img/slider_1.webp" alt="banner 1"></div>
            <div class="slide"><img src="/img/slider_2.webp" alt="banner 2"></div>
            <div class="slide"><img src="/img/slider_3.webp" alt="banner 3"></div>
        </div>
    </div>

    <div class="slider-controls">
        <button class="prev">❮</button>
        <button class="next">❯</button>
    </div>
</section>

<section>
    <div class="all-policy">
        <div class="support">
            <div class="policy-item">
                <i class="fa-solid fa-truck-fast"></i>
                <div class="info-policy">
                    <p style="font-size: 16px; font-weight: bold; text-transform: uppercase;">FreeShip</p>
                    <p style="font-size: small;">Giao hàng miễn phí</p>
                </div>
            </div>

            <div class="policy-item">
                <i class="fa-solid fa-repeat"></i>
                <div class="info-policy">
                    <p style="font-size: 16px; font-weight: bold; text-transform: uppercase;">Hoàn trả</p>
                    <p style="font-size: small;">Trong 30 ngày miễn phí</p>
                </div>
            </div>

            <div class="policy-item">
                <i class="fa-brands fa-cc-visa"></i>
                <div class="info-policy">
                    <p style="font-size: 16px; font-weight: bold; text-transform: uppercase;">Thanh toán</p>
                    <p style="font-size: small;">Hỗ trợ nhiều hình thức</p>
                </div>
            </div>

            <div class="policy-item">
                <i class="fa-solid fa-headset"></i>
                <div class="info-policy">
                    <p style="font-size: 16px; font-weight: bold; text-transform: uppercase;">Hỗ trợ</p>
                    <p style="font-size: small;">24/7</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="title">
        <a href="">Sản phẩm nổi bật</a>
        <div class="leaf">
              {{-- <i style="color: #7cc652;" class="fa-solid fa-leaf"></i> --}}
              🌿
        </div>
    </div>
</section>

<section>
    @if (!isset($category))
    <div class="hot-container">
        <div class="hot-items-wrapper" style="overflow:hidden; position:relative;">
            <div class="hot-items" style="display:flex; transition:transform 0.5s;">
                @isset($hotProducts)
                @foreach ($hotProducts as $product)
                    <div class="hot-product">
                        <a href="{{ route('detail', $product->id) }}">
                            <div class="hot-product-img">
                                <div class="hot-badge">HOT</div>
                                @if ($product->images->isNotEmpty())
                                    <img src="{{ asset('img/' . $product->images->first()->name) }}" alt="{{ $product->images->first()->name }}">
                                @else
                                    <img src="{{ asset('img/default.jpg') }}" alt="default">
                                @endif
                            </div>
                            <div class="hot-product-info">
                                <div class="hot-name">
                                    <p>{{ $product->name }}</p>
                                </div>
                                <div class="hot-price">
                                    @if ($product->sale_price)
                                        <del style="color: #858585;">{{ number_format($product->price) }}₫</del>
                                        <span style="color: #7cc652; font-weight: 700;">{{ number_format($product->sale_price) }}₫</span>
                                    @else
                                        <span style="color: #7cc652; font-weight: 700;">{{ number_format($product->price) }}₫</span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
                @endisset
            </div>
        </div>
        @if(isset($hotProducts) && count($hotProducts) > 4)
        <div class="hotProduct-controls">
            <button class="prev">❮</button>
            <button class="next">❯</button>
        </div>
        @endif
    </div>
    @endif
</section>

    <section>
        <div class="banner-mrk">
            <img src="/img/2banner_1.jpg" alt="">
            <img src="/img/2banner_2.jpg" alt="">
        </div>
    </section>

    <section>
        <div class="title">
            <a href="">Danh sách sản phẩm</a>
            <div class="leaf">
                {{-- <i style="color: #7cc652;" class="fa-solid fa-leaf"></i> --}}
                🌿
            </div>
        </div>

        <div class="tab">
            <div class="btn-tab">
                <a href="{{ route('home') }}" class="{{ !isset($category) ? 'active' : '' }}">Tất cả</a>
                <a href="{{ route('category', 1) }}" class="{{ (isset($category) && $category->id == 1) ? 'active' : '' }}">Trái cây</a>
                <a href="{{ route('category', 2) }}" class="{{ (isset($category) && $category->id == 2) ? 'active' : '' }}">Rau củ</a>
                <a href="{{ route('category', 3) }}" class="{{ (isset($category) && $category->id == 3) ? 'active' : '' }}">Thực phẩm</a>
            </div>

            <form action="{{ route('search') }}" method="get">
                <div class="search">
                    <input type="text" name="name" placeholder="Tìm kiếm...">
                </div>
            </form>
        </div>

    @if ($products->isEmpty())
        <p>Không tìm thấy sản phẩm nào.</p>
    @else
    <div class="productList">
        @foreach ($products as $product)
        <div class="product">
            <a href="{{ route('detail', $product->id) }}">
                @if ($product->images->isNotEmpty())
                    <div class="product-img">
                        <img src="{{ asset('img/' . $product->images->first()->name) }}" alt="{{ $product->images->first()->name }}">
                    </div>
                @else
                    <div class="product-img">
                        <img src="{{ asset('img/default.jpg') }}" alt="default">
                    </div>
                @endif
                <div class="product-info">
                    <div class="product-name">
                        <p>{{ $product->name }}</p>
                    </div>
                    <div class="product-price">
                        @if ($product->sale_price)
                            <del style="color: #858585;">{{ number_format($product->price) }}₫</del>
                            <span style="color: #7cc652; font-weight: 700;">{{ number_format($product->sale_price) }}₫</span>
                        @else
                            <span style="color: #7cc652; font-weight: 700;">{{ number_format($product->price) }}₫</span>
                        @endif
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
    @endif

    <div class="page">
        <div class="btn-page">
            @if ($products instanceof \Illuminate\Pagination\LengthAwarePaginator)
            {{ $products->links('pagination::bootstrap-4')}}
            @endif
        </div>
    </div>
</section>
@endsection
