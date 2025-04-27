<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login'    => 'required|string|email',
            'password' => 'required|string',
        ]);

        $key = Str::lower($request->input('login')).'|'.$request->ip();
        $maxAttempts = 3;
        $decaySeconds = 60;

        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($key);
            return response()->json([
                'success' => false,
                'error'   => "Превышено количество попыток. Попробуйте снова через $seconds секунд."
            ], 429);
        }

        if (Auth::attempt(['email' => $request->login, 'password' => $request->password])) {
            RateLimiter::clear($key);
            $request->session()->regenerate();

            $user = Auth::user();

            $redirect = session()->pull('url.intended', 
                $user->role === 'admin' 
                    ? route('home') 
                    : route('dashboard')
            );

            return response()->json([
                'success'       => true,
                'redirect_from' => $redirect,
            ]);
        }

        RateLimiter::hit($key, $decaySeconds);

        return response()->json([
            'success' => false,
            'error'   => 'Неверный логин или пароль',
        ], 401);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect(route('home'));
    }

    public function showRegistrationForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'fullName'        => 'required|string|max:255',
            'email'           => 'required|string|email|max:255|unique:users,email',
            'password'        => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'full_name'     => $data['fullName'],
            'email'         => $data['email'],
            'password'      => $data['password'],
        ]);

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}