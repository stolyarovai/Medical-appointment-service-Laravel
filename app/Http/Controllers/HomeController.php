<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        return view('index', [
            'isLoggedIn' => Auth::check(),
            'userName'   => Auth::check() ? Auth::user()->full_name : null,
        ]);
    }

    public function help()
    {
        return view('help');
    }
}
