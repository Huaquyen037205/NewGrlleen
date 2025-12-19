<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ</title>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/detail.css">
    <link rel="stylesheet" href="/css/register.css">
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/5a06f65a96.js" crossorigin="anonymous"></script>
</head>
<body>
    <header>
    <div class="logo">
        <img src="/img/logo.webp" alt="logo">
    </div>
    <nav>
        <ul>
            <li><a style="color: #7cc652;" href="{{ route('home') }}">Trang chủ</a></li>
            <li><a href="{{route('contact')}}">Liên hệ</a></li>
            <li>
                <a href="{{ route('cart.index') }}" style="color: #7cc652; position: relative;">
                    Giỏ hàng
                    @php
                        $cartCount = 0;
                        if (session('cart')) {
                            foreach (session('cart') as $item) {
                                $cartCount += $item['quantity'] ?? 0;
                            }
                        }
                    @endphp
                    @if ($cartCount > 0)
                        <span class="cart-count">{{ $cartCount }}</span>
                    @endif
                </a>
            </li>
            @if (auth()->check())
                {{-- <li><i class="fa-regular fa-user"></i></li> --}}
                <a href="{{ route('profile.infoAccount')}}"><li><span style="font-size: 15px">Xin chào, {{ auth()->user()->name }}</span></li></a>
            @else
                {{-- <li><a style="color: #7cc652; font-weight: 700;" href="service.html">Hotline:1900 5678</a></li> --}}
                <li><a href="{{ route('login') }}"><i class="fa-regular fa-user"></i></a></li>
            @endif
        </ul>
    </nav>
</header>

    @yield('content')

    <footer>
        <div class="footer-element">
            <div class="detail-info">
                <div class="logo">
                    <img src="/img/logo.webp" alt="">
                </div>

                <div class="contact-address">
                    <div class="address">
                        <i style="color: #00845c;" class="fa-solid fa-location-dot"></i>
                        <a href="">Tầng 11 Tòa T, Quận 12, Quang Trung, Tp.Hồ Chí Minh</a>
                    </div>

                    <div class="address">
                        <i style="color: #00845c;" class="fa-solid fa-phone"></i>
                        <a href="">1900 5678</a>
                    </div>

                    <div class="address">
                        <i style="color: #00845c;" class="fa-solid fa-envelope"></i>
                        <a style="color: #00845c; font-weight: 700;" href="">ReadTest@gmail.com</a>
                    </div>
                </div>
            </div>

            <div class="privacy">
                <ul>
                    <h3>Chăm sóc khách hàng</h3>
                    <li><a href="">Chính sách bảo mật</a></li>
                    <li><a href="">Chính sách vận chuyển</a></li>
                    <li><a href="">Chính sách đổi trả</a></li>
                    <li><a href="">Chính sách thanh toán</a></li>
                </ul>

                <ul>
                    <h3>Điều khoản</h3>
                    <li><a href="">Chính sách bảo mật</a></li>
                    <li><a href="">Chính sách vận chuyển</a></li>
                    <li><a href="">Chính sách đổi trả</a></li>
                    <li><a href="">Chính sách thanh toán</a></li>
                </ul>

                <ul>
                    <h3>Dịch vụ</h3>
                    <li><a href="">Chính sách bảo mật</a></li>
                    <li><a href="">Chính sách vận chuyển</a></li>
                    <li><a href="">Chính sách đổi trả</a></li>
                    <li><a href="">Chính sách thanh toán</a></li>
                </ul>
            </div>
        </div>
    </footer>
</body>
<script src="/js/main.js"></script>
</html>
