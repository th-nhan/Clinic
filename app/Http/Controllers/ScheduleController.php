<?php

namespace App\Http\Controllers; 

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index() // <--- Đây là phương thức bị thiếu hoặc sai tên
    {
        $schedule = Schedule::with(['user','scheduletime'])->get();
        return view('QuanLyLichLamViec.index', compact('schedule')); 
    }
}