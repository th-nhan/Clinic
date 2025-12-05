<?php

namespace App\Http\Controllers;

use App\Models\HistoryDetail;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;

class HistoryDetailController extends Controller
{
    public function index() {
        $histories = HistoryDetail::with(relations:['history', 'service']);
        return view('QuanLyLichSu.index', compact('histories'));
    }
}
