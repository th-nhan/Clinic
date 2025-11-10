<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Hiển thị trang chủ/dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // 'home' ở đây là tên của file view: resources/views/home.blade.php
        return view('home');
    }
}