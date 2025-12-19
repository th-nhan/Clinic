<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\GoogleController;


// 1. Khi người dùng vào /login (GET), hiển thị form login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});
Route::get('/lichlamviec', [ScheduleController::class,'index'])->name('lichlamviec');


Route::get('/lichlamviec', [ScheduleController::class,'index'])->name('lichlamviec');
Route::apiResource('lichsu', HistoryController::class);
Route::apiResource('hoadon', InvoiceController::class);
// Route::get('/service/{id}', function($id) {
//     return App\Models\Service::find($id);
// });
Route::get('/lichsu', [HistoryController::class,'index'])->name('lichsu.index');

Route::get('/customers/overview', [CustomerController::class, 'overview']);
Route::get('/customers/search', [CustomerController::class, 'search']);

Route::delete('/lich/delete-many', [ScheduleController::class, 'deleteMany'])->name('lich.deleteMany');
Route::apiResource('lich',ScheduleController::class);


Route::get('/invoice/{id}/pay', [InvoiceController::class, 'paymentPage'])->name('payment.page');
Route::post('/invoice/cash', [InvoiceController::class, 'cash_payment'])->name('payment.cash');
Route::post('/invoice/momo', [InvoiceController::class, 'momo_payment'])->name('payment.momo');
Route::get('/payment/result', [InvoiceController::class, 'paymentResult'])->name('payment.result');
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');

// Route Google gọi về sau khi đăng nhập xong
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);
require __DIR__ . '/settings.php';
