<?php

namespace App\Http\Controllers; 

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index() 
    {
        $schedule =  Schedule::with(['user','scheduletime'])->get();
        // $user = User::all();
        return view('QuanLyLichLamViec.index',compact('schedule'));
    }
}