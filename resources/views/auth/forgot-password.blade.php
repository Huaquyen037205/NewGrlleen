@extends('template.user')
@section('content')
<h1>Quên mật khẩu</h1>
<form action="{{ route('password.email') }}" method="POST">
    @csrf
    <input type="email" name="email" placeholder="Email" required>
    <button type="submit">Gửi liên kết đặt lại mật khẩu</button>
</form>
@endsection
