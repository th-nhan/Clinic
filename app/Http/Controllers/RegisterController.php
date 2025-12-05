<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegisterForm(){
        return view('DangNhap.register');
    }

    public function register(Request $request){
        $fullname = $request->input('fullname');
        $email = $request->input('email');
        $password = $request->input('password');
        $confirmPassword = $request->input('confirm-password');

        $nameRegex = '/^[\p{L}]+(\s[\p{L}]+)+$/u';

        if(!preg_match($nameRegex, $fullname)){
            return back()->with('error', 'Tên phải có ít nhất 2 từ')->withInput();
        }
        $userExists = User::where('email', $email)->exists();
        if ($userExists) {
            return back()->with('error', 'Email này đã được đăng ký bởi người khác.')->withInput();
        }
        if (strlen($password) < 6) {
            return back()->with('error', 'Mật khẩu phải có ít nhất 6 ký tự.')->withInput();
        }
        if ($password !== $confirmPassword) {
            return back()->with('error', 'Mật khẩu nhập lại không khớp.')->withInput();
        }
        $user = User::create([
            'fullname' => $fullname,
            'email'    => $email,
            'password' => Hash::make($password),
        ]);
        Auth::login($user);

        return redirect()->route('login');
    }
}
