@extends('template.user')
@section('content')
<div class="register-page">
    <div class="form-register">
        <h1>Đăng ký</h1>

        <form action="{{ route('register.post') }}" method="POST">
            @csrf
            <input type="text" name="name" placeholder="Tên" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="phone" placeholder="Số điện thoại" required>
            <input type="password" name="password" placeholder="Mật khẩu" required>
            <input type="password" name="password_confirmation" placeholder="Xác nhận mật khẩu" required>
            <button type="submit">Đăng ký</button>
        </form>

        <div class="reset-pass">
            <p>Đã có tài khoản? <a href="{{ route('login') }}">Đăng nhập ngay</a></p>
        </div>
    </div>
</div>
@endsection


