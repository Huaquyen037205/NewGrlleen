@extends('template.user')
@section('content')
<script src="https://cdn.tailwindcss.com"></script>
    <div class="flex items-center justify-center min-h-[80vh] bg-gray-45">
        <div class="w-full max-w-md bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition">

            <h2 class="text-2xl font-bold text-center text-green-700 mb-6">
                Đặt lại mật khẩu
            </h2>

            {{-- Error --}}
            @if ($errors->any())
                <div class="bg-red-50 text-red-600 px-4 py-2 rounded-lg mb-4 text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            {{-- Success --}}
            @if (session('status'))
                <div class="bg-green-50 text-green-700 px-4 py-2 rounded-lg mb-4 text-sm">
                    {{ session('status') }}
                </div>
            @endif

            <form action="{{ route('password.update') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div>
                    <label class="block text-sm mb-1 text-gray-600">Email</label>
                    <input type="email" name="email" value="{{ old('email', $email ?? '') }}"
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400"
                        required>
                </div>

                <div>
                    <label class="block text-sm mb-1 text-gray-600">Mật khẩu mới</label>
                    <input type="password" name="password"
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400"
                        required>
                </div>

                <div>
                    <label class="block text-sm mb-1 text-gray-600">Xác nhận mật khẩu</label>
                    <input type="password" name="password_confirmation"
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400"
                        required>
                </div>

                <button type="submit"
                    class="w-full bg-gradient-to-r from-green-500 to-green-700 text-white py-2 rounded-lg font-semibold hover:opacity-90 transition">
                    Đặt lại mật khẩu
                </button>
            </form>

            <div class="text-center mt-4 text-sm text-gray-600">
                <a href="{{ route('login') }}" class="text-green-700 font-semibold hover:underline">
                    Quay lại đăng nhập
                </a>
            </div>
        </div>
    </div>
@endsection
