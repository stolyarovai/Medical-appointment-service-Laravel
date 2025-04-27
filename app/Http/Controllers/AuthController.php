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
        return view('login', [
            'title'  => 'Вход',
            'action' => route('login.attempt'),
            'id'     => 'loginForm',
            'script' => 'login',
        ]);
    }

    public function showRegistrationForm()
    {
        return view('register', [
            'title'  => 'Регистрация',
            'action' => route('register.attempt'),
            'id'     => 'registrationForm',
            'script' => 'register',
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|string|email',
            'password' => 'required|string',
        ]);

        $key = Str::lower($request->input('email')).'|'.$request->ip();
        $maxAttempts = 3;
        $decaySeconds = 60;

        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($key);
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'error'   => "Превышено количество попыток. Попробуйте снова через $seconds секунд."
                ]);
            }
            
            return back()->with('error', "Превышено количество попыток. Попробуйте снова через $seconds секунд.")->withInput();
        }

        if (Auth::attempt($credentials)) {
            RateLimiter::clear($key);
            $request->session()->regenerate();

            $user = Auth::user();
            $redirect = session()->pull('url.intended', 
                $user->role === 'admin' 
                    ? route('home') 
                    : route('dashboard')
            );

            if ($request->expectsJson()) {
                return response()->json([
                    'success'       => true,
                    'redirect_from' => $redirect,
                ]);
            }
            
            return redirect($redirect);
        }

        RateLimiter::hit($key, $decaySeconds);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'error'   => 'Неверный логин или пароль',
            ]);
        }
        
        return back()->with('error', 'Неверный логин или пароль')->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect(route('home'));
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