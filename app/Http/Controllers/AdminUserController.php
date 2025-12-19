<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function updateUser(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'required|string|max:20',
        ]);

        $user = User::find($id);

        if (!$user) {
            return back()->with('error', 'Không tìm thấy người dùng!');
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        return redirect()->route('profile.infoAccount')
            ->with('success', 'Cập nhật thông tin thành công!');
    }

    public function deleteUser($id)
    {
        $user = Users::find($id);
        if ($user) {
            try {
                $user->delete();
                return redirect()->route('admin.user')->with('success', 'Người dùng đã được xóa thành công!');
            } catch (\Exception $e) {
                return redirect()->route('admin.user')->with('error', 'Không thể xóa người dùng do ràng buộc dữ liệu!');
            }
        }

        return redirect()->route('admin.user')->with('error', 'Không tìm thấy người dùng!');
    }
}
