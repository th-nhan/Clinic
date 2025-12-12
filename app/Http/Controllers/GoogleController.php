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
        // Quan trọng: dùng stateless() để tránh lỗi state mismatch
        $googleUser = Socialite::driver('google')->stateless()->user();

    } catch (\Exception $e) {
        dd("Google Login Error: " . $e->getMessage());
    }

    // Tìm user theo google_id
    $findUser = User::where('google_id', $googleUser->id)->first();

    if ($findUser) {
        Auth::login($findUser);
        return redirect()->route('home')->with('success', 'Đăng nhập Google thành công!');
    }

    // Nếu email tồn tại -> cập nhật google_id
    $existingUser = User::where('email', $googleUser->email)->first();

    if ($existingUser) {
        $existingUser->google_id = $googleUser->id;
        $existingUser->save();

        Auth::login($existingUser);
        return redirect()->route('home');
    }

    // Tạo user mới
    $newUser = User::create([
        'fullname' => $googleUser->name,
        'email' => $googleUser->email,
        'google_id' => $googleUser->id,
        'password' => Hash::make(Str::random(16)),
    ]);

    Auth::login($newUser);
    return redirect()->route('home');
}

}