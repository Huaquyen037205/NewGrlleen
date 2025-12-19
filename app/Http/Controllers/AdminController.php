<?php

namespace App\Http\Controllers;
use App\Models\Products;
use App\Models\Categories;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function showLoginForm() {
        return view('manager.loginAdmin');
    }

    public function loginAdmin(Request $request)
    {
            $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if (isset($user->role) && $user->role !== 'admin') {
                Auth::logout();
                return redirect()->route('manager.loginAdmin')->withErrors([
                    'email' => 'Chỉ tài khoản admin mới được phép đăng nhập.'
                ]);
            }

            if ($user->is_active === 'off') {
                Auth::logout();
                return redirect()->route('manager.loginAdmin')->withErrors([
                    'email' => 'Tài khoản đã bị khóa'
                ]);
            }

            return redirect()->route('admin.dashboard')->with('success', 'Đăng nhập thành công');
        }

            return back()->withErrors([
                'email' => 'Email hoặc mật khẩu không đúng',
            ]);
    }

    public function dashboard(Request $request)
    {
        $products = Products::with('images', 'variants')->paginate(5);
        $data = [
            'products' => $products,
        ];
        return view('admin.dashboard', $data);
    }

    public function updateView() {
        $categories = Categories::all();
        return view('admin.update', ['categories' => $categories]);
    }

    public function user() {
        $user = User::paginate(5);
        $data = [
            'user' => $user,
        ];
        return view('admin.user', $data);
    }

    public function updateCategory() {
        return view('admin.CategoryUpdate');
    }
}
