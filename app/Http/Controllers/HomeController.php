<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('index', [
            'isLoggedIn' => auth()->check(),
            'userName'   => auth()->check() ? auth()->user()->full_name : null,
        ]);
    }
}
