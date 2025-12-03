<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <-- Thêm thư viện Auth

class LoginController extends Controller
{
    /**
     * Phương thức GET /login
     * Chỉ đơn giản là hiển thị file view chứa form đăng nhập.
     */
    public function showLoginForm()
    {
        // Trả về file: resources/views/login.blade.php (hoặc tên view của bạn)
        return view('DangNhap.login');
    }

    /**
     * Phương thức POST /login
     * Xử lý dữ liệu khi người dùng ấn nút "Đăng nhập".
     */
    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        if (empty($email) || empty($password)) {
            return back()->with('error', 'Vui lòng nhập đầy đủ Email và Mật khẩu!')->withInput();
        }
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            return redirect()->route('home')->with('success', 'Đăng nhập thành công!');
        }
        return back()->with('error', 'Email hoặc mật khẩu không chính xác.')->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();

        return redirect()->route('login');
    }
}
