<?php

namespace App\Http\Controllers; 

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index() // <--- Đây là phương thức bị thiếu hoặc sai tên
    {
        // Trả về view index.blade.php của lịch làm việc
        return view('QuanLyLichLamViec.index'); 
        // Thay 'working_schedule.index' bằng đường dẫn view chính xác của bạn
    }
}