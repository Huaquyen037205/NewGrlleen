@extends('template.user')
@section('content')
<div class="register-page">
    <div class="form-register">
        <h1>Đăng ký</h1>

        <form action="{{ route('register.post') }}" method="POST">
            @csrf
            @error('name')
                <p style="color:red">{{ $message }}</p>
            @enderror
            <input type="text" name="name" placeholder="Tên" value="{{ old('name') }}">

            @error('email')
                <p style="color:red">{{ $message }}</p>
            @enderror
            <input type="email" name="email" placeholder="Email" value="{{ old('email') }}">

            @error('phone')
                <p style="color:red">{{ $message }}</p>
            @enderror
            <input type="text" name="phone" placeholder="Số điện thoại" value="{{ old('phone') }}">

             @error('password')
                <p style="color:red">{{ $message }}</p>
            @enderror
            <input type="password" name="password" placeholder="Mật khẩu">

            @error('password_confirmation')
                <p style="color:red">{{ $message }}</p>
            @enderror
            <input type="password" name="password_confirmation" placeholder="Xác nhận mật khẩu">


            <button type="submit">Đăng ký</button>
        </form>

        <div class="reset-pass">
            <p>Đã có tài khoản? <a href="{{ route('login') }}">Đăng nhập ngay</a></p>
        </div>
    </div>
</div>
@endsection


