<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:15',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Đăng ký thành công! Vui lòng đăng nhập.');
    }


    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->is_active === 'off') {
                Auth::logout();
                return redirect()->route('login')->withErrors([
                    'email' => 'Tài khoản đã bị khóa'
                ]);
            }

        return redirect()->route('home')->with('success', 'Đăng nhập thành công');
    }

    return back()->withErrors([
        'email' => 'Email hoặc mật khẩu không đúng',
    ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Đăng xuất thành công!');
    }


    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }


    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);



        return back()->with('success', 'Liên kết đặt lại mật khẩu đã được gửi đến email của bạn.');
    }
}
