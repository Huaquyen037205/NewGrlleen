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
                       <button type="submit" class="flex items-center  gap-3 px-4 py-2.5 rounded-lg text-sm font-medium text-green-600 hover:bg-green-50 hover:text-green-700 w-[200px] ml-[120px] justify-start">
                        <i class="fa-solid fa-right-from-bracket w-5"></i> Đăng xuất </button>
                    </form>
                </nav>
            </div>
        </aside>

        <section class="col-span-9">
            <div class="bg-white border rounded-xl shadow-sm p-8">
                <h2 class="text-2xl font-bold text-green-600 mb-1">Thông tin tài khoản</h2>
                <p class="text-sm text-gray-400 mb-8">
                    Cập nhật thông tin cá nhân của bạn để thuận tiện cho việc mua hàng
                </p>

                <form action="{{ route('profile.infoAccount.update', $user->id) }}" method="POST" class="grid grid-cols-2 gap-6">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="text-sm text-gray-500 font-medium">Họ và tên</label>
                        <input type="text" name="name" value="{{old('name', $user->name)}}"
                            class="mt-1 w-full border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-200" />
                    </div>

                    <div>
                        <label class="text-sm text-gray-500 font-medium">Email</label>
                        <input type="email" name="email" value="{{old('email', $user->email)}}"
                            class="mt-1 w-full border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-200" />
                    </div>

                    <div>
                        <label class="text-sm text-gray-500 font-medium">Số điện thoại</label>
                        <input type="tel" name="phone" value="{{old('phone', $user->phone)}}"
                            class="mt-1 w-full border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-200" />
                    </div>

                    <div class="col-span-2">
                        <label class="text-sm text-gray-500 font-medium">Địa chỉ</label>
                        <textarea rows="3"
                            class="mt-1 w-full border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-200 resize-none">{{optional($user->address)->address}}</textarea>
                    </div>

                    <div class="col-span-2 flex justify-end">
                        <button type="submit"
                            class="bg-gradient-to-r from-green-500 to-emerald-600 text-white px-6 py-2 rounded-lg font-medium hover:shadow-md transition">
                            Lưu thay đổi
                        </button>
                    </div>
                </form>
            </div>
        </section>

    </main>
@endsection
