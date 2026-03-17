@extends('template.user')
@section('content')
    <script src="https://cdn.tailwindcss.com"></script>
    <main class="max-w-6xl mx-auto px-6 py-12 grid grid-cols-12 gap-8">

        <aside class="col-span-3">
            <div class="bg-white border rounded-xl shadow-sm p-6">
                <h2 class="text-xl font-semibold text-green-600 mb-4">Tài khoản của tôi</h2>
                <hr class="mb-4 border-gray-100">
                <nav class="flex flex-col items-center space-y-2">

                    <a href="{{ route('profile.infoAccount') }}"
                        class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium w-[200px] mx-auto
                    {{ request()->routeIs('profile.infoAccount') ? 'bg-gradient-to-r from-green-500 to-emerald-600 text-white' : 'text-green-600 hover:bg-green-50 hover:text-green-700' }}">
                        <i class="fa-solid fa-user w-5"></i>
                        Thông tin cá nhân
                    </a>

                    <a href="{{ route('profile.order') }}"
                        class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium w-[200px] mx-auto
                    {{ request()->routeIs('profile.order') ? 'bg-gradient-to-r from-green-500 to-emerald-600 text-white' : 'text-green-600 hover:bg-green-50 hover:text-green-700' }}">
                        <i class="fa-solid fa-box-archive w-5"></i>
                        Đơn hàng
                    </a>

                    <a href="{{ route('address') }}"
                        class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium w-[200px] mx-auto
                    {{ request()->routeIs('address') ? 'bg-gradient-to-r from-green-500 to-emerald-600 text-white' : 'text-green-600 hover:bg-green-50 hover:text-green-700' }}">
                        <i class="fa-solid fa-location-dot w-5"></i>
                        Địa chỉ
                    </a>

                    <form action="{{ route('logout') }}" method="POST" id="logout-form" class="mt-2">
                        @csrf
                        <button type="submit"
                            class="flex items-center  gap-3 px-4 py-2.5 rounded-lg text-sm font-medium text-green-600 hover:bg-green-50 hover:text-green-700 w-[200px] ml-[120px] justify-start">
                            <i class="fa-solid fa-right-from-bracket w-5"></i> Đăng xuất </button>
                    </form>
                </nav>
            </div>
        </aside>
        <section class="col-span-9">
            <div class="bg-white border rounded-xl shadow-sm p-8">
                <h2 class="text-2xl font-bold text-green-600 mb-1">Chi tiết đơn hàng</h2>
                <p class="text-sm text-gray-400 mb-6">Xem thông tin sản phẩm và tổng tiền đơn hàng của bạn</p>

                <div class="space-y-4">
                    @foreach ($items as $item)
                        <div
                            class="flex items-center justify-between bg-green-50 p-4 rounded-lg shadow-sm hover:shadow-md transition">
                            <img src="{{ asset('img/' . ($item->image ?? 'default.jpg')) }}" alt="{{ $item->product_name }}"
                                class="w-16 h-16 object-cover rounded-lg">
                            <div class="flex-1 ml-4">
                                <p class="font-semibold text-gray-700">{{ $item->product_name }}</p>
                                <p class="text-sm text-gray-500">Size: {{ $item->size }}</p>
                            </div>
                            <p class="text-gray-700 font-medium mr-[10px]">x{{ $item->quantity }}</p>
                            <p class="text-gray-700 font-semibold">{{ number_format($item->price) }}₫</p>
                        </div>
                    @endforeach
                </div>

                @php
                    $subtotal = $items->sum(fn($i) => $i->price * $i->quantity);
                    $total = $subtotal + $shipping_fee;
                @endphp
                <div class="mt-6 text-right space-y-1">
                    <p class="text-gray-600">Tạm tính: <span class="font-semibold">{{ number_format($subtotal) }}₫</span>
                    </p>
                    <p class="text-gray-600">Phí vận chuyển: <span
                            class="font-semibold">{{ number_format($shipping_fee) }}₫</span></p>
                    <p class="text-green-600 font-bold text-lg">Tổng cộng: <span>{{ number_format($total) }}₫</span></p>
                </div>

                <div class="mt-6 flex justify-end">
                    <a href="{{ route('profile.order') }}"
                        class="bg-gradient-to-r from-green-500 to-emerald-600 text-white px-4 py-2 rounded-lg hover:shadow-md transition">
                        ← Quay lại danh sách
                    </a>
                </div>
            </div>
        </section>

    </main>
@endsection
