@extends('template.user')
@section('content')
    <script src="https://cdn.tailwindcss.com"></script>

    <main class="max-w-6xl mx-auto px-6 py-32 grid grid-cols-12 gap-8">

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
            <div class="bg-white rounded-xl shadow-sm p-8 border">
                <h2 class="text-2xl font-bold text-green-600 mb-2">Địa chỉ của tôi</h2>
                <p class="text-sm text-gray-500 mb-6">Quản lý địa chỉ để thuận tiện cho việc giao hàng</p>

                <form class="flex gap-3 mb-6" action="{{ route('profile.address.add') }}" method="POST">
                    @csrf
                    <input type="text" name="address" placeholder="Thêm địa chỉ mới..."
                        class="flex-1 border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-200" />
                    <button type="submit"
                        class="bg-green-500 text-white px-4 py-2 rounded-lg font-medium hover:bg-green-600 transition">+
                        Thêm</button>
                </form>

                @if ($addresses->isEmpty())
                    <p class="text-gray-500 text-sm">Bạn chưa có địa chỉ nào. Vui lòng thêm địa chỉ để thuận tiện cho việc
                        giao hàng.</p>
                @else
                    <div class="flex flex-col gap-3">
                        @foreach ($addresses as $addr)
                            <div class="flex justify-between items-center p-3 border rounded-lg hover:shadow-sm transition">
                                <p class="text-gray-700">
                                    {{ $addr->address }}
                                    @if ($addr->is_default)
                                        <span class="text-green-600 font-semibold ml-2">(Mặc định)</span>
                                    @endif
                                </p>
                                @if (!$addr->is_default)
                                    <form action="{{ route('profile.address.default', $addr->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="text-green-600 font-medium hover:text-green-700 transition">Đặt làm mặc
                                            định</button>
                                    </form>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif

            </div>
        </section>

    </main>
@endsection
