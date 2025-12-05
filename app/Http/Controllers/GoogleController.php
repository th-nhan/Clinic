<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str; // Để tạo mật khẩu ngẫu nhiên

class GoogleController extends Controller
{
    // 1. Chuyển hướng người dùng sang trang đăng nhập của Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // 2. Xử lý khi Google gọi lại (Callback)
    public function handleGoogleCallback()
    {
        try {
            // Lấy thông tin user từ Google
            $googleUser = Socialite::driver('google')->user();

            // Tìm user trong DB dựa trên google_id
            $finduser = User::where('google_id', $googleUser->id)->first();

            if ($finduser) {
                // Nếu đã tồn tại -> Đăng nhập
                Auth::login($finduser);
                return redirect()->route('home')->with('success', 'Đăng nhập Google thành công!');
            } else {
                // Nếu chưa có google_id, kiểm tra xem email đã tồn tại chưa
                $existingUser = User::where('email', $googleUser->email)->first();

                if ($existingUser) {
                    // Email đã có (do đăng ký thường), cập nhật google_id cho user đó
                    $existingUser->google_id = $googleUser->id;
                    $existingUser->save();
                    Auth::login($existingUser);
                } else {
                    // Nếu chưa có gì cả -> Tạo tài khoản mới (Đăng ký)
                    // Lưu ý: Cột tên trong DB của bạn là 'fullname', Google trả về 'name'
                    $newUser = User::create([
                        'fullname' => $googleUser->name,
                        'email' => $googleUser->email,
                        'google_id' => $googleUser->id,
                        'password' => Hash::make(Str::random(16)), // Tạo pass ngẫu nhiên để bảo mật
                    ]);
                    Auth::login($newUser);
                }

                return redirect()->route('home')->with('success', 'Đăng ký/Đăng nhập Google thành công!');
            }

        } catch (\Exception $e) {
            // Nếu lỗi (ví dụ hủy đăng nhập)
            dd($e->getMessage());
            return redirect()->route('login')->with('error', 'Đăng nhập Google thất bại, vui lòng thử lại.');
        }
    }
}