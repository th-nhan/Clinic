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
        // 1. Validate dữ liệu đầu vào (email, password)
        // $credentials = $request->validate([
        //     'email' => ['required', 'email'],
        //     'password' => ['required'],
        // ]);

        // // 2. Thử đăng nhập
        // //    Hàm Auth::attempt() sẽ tự động hash password và so sánh với
        // //    password đã hash trong database.
        // if (Auth::attempt($credentials)) {
            
        //     // Nếu ĐĂNG NHẬP THÀNH CÔNG:

        //     // Tạo lại session ID để bảo mật (tránh session fixation)
        //     $request->session()->regenerate();

        //     // Chuyển hướng người dùng về trang họ muốn (hoặc trang /home)
        //     // 'intended' rất hay, nó sẽ đưa người dùng về trang
        //     // mà họ bị chặn (ví dụ /admin) trước khi bị bắt login.
        //     return redirect()->intended('home');
        // }

        // // 3. Nếu ĐĂNG NHẬP THẤT BẠI:
        // //    Quay lại form login và gửi kèm một lỗi
        // return back()->withErrors([
        //     'email' => 'Thông tin đăng nhập (email hoặc mật khẩu) không chính xác.',
        // ])->onlyInput('email'); // Giữ lại email đã nhập

        return redirect()->intended('home');
    }
}