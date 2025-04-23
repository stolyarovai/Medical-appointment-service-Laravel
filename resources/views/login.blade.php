@extends('layouts.main')

@section('title', 'Вход')
@section('style', 'form')
@section('script', 'login')

@section('content')
    <form method="POST" action="{{ route('login.attempt') }}" id="loginForm">
        @csrf

        {{-- Логин --}}
        <div class="form-group">
            <label for="login">Логин</label>
            <input type="text"
                   id="login"
                   name="login"
                   value="{{ old('login') }}"
                   placeholder="Введите логин или email"
                   required
                   autofocus>
            @error('login')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        {{-- Пароль --}}
        <div class="form-group">
            <label for="password">Пароль</label>
            <input type="password"
                   id="password"
                   name="password"
                   placeholder="Введите пароль"
                   required>
            @error('password')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        {{-- Запомнить --}}
        <div class="form-group">
            <label>
                <input type="checkbox" name="remember">
                Запомнить меня
            </label>
        </div>

        {{-- Кнопка --}}
        <button type="submit" id="submitButton">Войти</button>

        @if($errors->has('login'))
            <div class="error" id="Error">{{ $errors->first('login') }}</div>
        @endif

        <p>Нет аккаунта? <a href="{{ route('register') }}">Регистрация</a></p>
    </form>
@endsection
