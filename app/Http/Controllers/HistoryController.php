<?php

namespace App\Http\Controllers;

use App\Models\history;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function getNameService(){
    }
    public function index(){

        $histories = History::with(relations: ['Customer', 'User', 'Invoice', 'historyDetails.service'])->get();
        $users = User::all();
        $services = Service::all();
        return view('QuanLyLichSu.index', compact('histories','users','services'));
    }
}