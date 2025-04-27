@extends('layouts.form')

@section('content')
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

    <p>Нет аккаунта? <a href="{{ route('register') }}">Регистрация</a></p>
@endsection
