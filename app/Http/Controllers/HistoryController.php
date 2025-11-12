<?php

namespace App\Http\Controllers;

use App\Models\history;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function getNameService(){
    }
    public function index(){
    $histories = History::with(['Customer', 'User', 'Invoice', 'historyDetails.service'])->get();
    return view('QuanLyLichSu.index', compact('histories'));
    }
}
