<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;
use App\Http\Controllers\ScheduleController;

// Route::get('/', function () {
//     return Inertia::render('welcome', [
//         'canRegister' => Features::enabled(Features::registration()),
//     ]);
// })->name('home');

Route::get('/', function () {
    return view('home');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});

Route::get('/lich-lam-viec', [ScheduleController::class, 'index'])->name('QuanLyLichLamViec.index');
Route::get('/lichsu', function () {
    return view('QuanLyLichSu.index');
})->name('QuanLyLichSu.index');
require __DIR__ . '/settings.php';
