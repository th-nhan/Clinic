<?php

use App\Http\Controllers\HistoryController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;



// Route::get('/home', function () {
//     return view('home');
// })->name('home');

// 1. Khi người dùng vào /login (GET), hiển thị form login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');

// 2. Khi người dùng submit form (POST) từ /login, hàm 'login' sẽ xử lý
Route::post('/login', [LoginController::class, 'login']);

// 3. Trang chủ (dashboard), chỉ cho phép vào sau khi đã login
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});

Route::get('/lichlamviec', function(){
    return view('QuanLyLichLamViec.index');
})->name('QuanLyLichLamViec.index');
Route::get('/lichsu', [HistoryController::class,'index'])->name('lichsu');
// Route::get('/login', function () {
//     return view('DangNhap.login');
// })->name('DangNhap.login');
require __DIR__ . '/settings.php';
