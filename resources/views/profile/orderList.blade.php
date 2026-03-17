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
                <h2 class="text-2xl font-bold text-green-600 mb-2">Đơn hàng của bạn</h2>
                <p class="text-sm text-gray-400 mb-6">Theo dõi trạng thái và chi tiết các đơn hàng của bạn</p>

                @if ($orders->isEmpty())
                    <div class="text-center p-8 bg-green-50 rounded-lg">
                        <img src="https://cdn-icons-png.flaticon.com/512/4076/4076505.png" class="mx-auto w-28 mb-4"
                            alt="no orders">
                        <p class="text-gray-500">Bạn chưa có đơn hàng nào.</p>
                    </div>
                @else
                    <div class="flex flex-col gap-4">
                        @foreach ($orders as $order)
                            <div
                                class="bg-green-50 border border-green-100 rounded-lg p-4 shadow-sm hover:shadow-md transition">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <h4 class="font-semibold text-gray-700">Mã đơn:
                                            <span>{{ $order->order_code }}</span>
                                        </h4>
                                        <p class="text-gray-500 text-sm">Ngày đặt:
                                            {{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y') }}</p>
                                    </div>
                                    <span
                                        class="px-2 py-1 rounded text-white text-sm font-medium {{ $order->status === 'pending'
                                            ? 'bg-yellow-400'
                                            : ($order->status === 'paid'
                                                ? 'bg-green-600'
                                                : ($order->status === 'processing'
                                                    ? 'bg-blue-600'
                                                    : 'bg-red-500')) }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <div class="text-gray-600">
                                        <p><strong>Tổng tiền:</strong> {{ number_format($order->total_amount) }}₫</p>
                                        <p><strong>Phương thức:</strong> {{ $order->payment_method ?? 'Chưa xác định' }}
                                        </p>
                                    </div>
                                    <a href="{{ route('profile.order.detail', $order->id) }}"
                                        class="px-4 py-2 bg-green-500 text-white rounded-lg text-sm font-medium hover:shadow-md transition">Xem
                                        chi tiết</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

            </div>
        </section>

    </main>
@endsection
