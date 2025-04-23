@extends('layouts.main')

@section('title', 'Регистрация')
@section('style', 'form')
@section('script', 'register')

@section('content')
    <form method="POST" action="{{ route('register.attempt') }}" id="registrationForm">
        @csrf

        {{-- ФИО --}}
        <div class="form-group">
            <label for="fullName">ФИО</label>
            <input type="text"
                   id="fullName"
                   name="fullName"
                   value="{{ old('fullName') }}"
                   placeholder="Введите ФИО"
                   required>
            @error('fullName')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        {{-- Email --}}
        <div class="form-group">
            <label for="email">E-mail</label>
            <input type="email"
                   id="email"
                   name="email"
                   value="{{ old('email') }}"
                   placeholder="Введите e-mail"
                   required>
            @error('email')
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

        {{-- Подтверждение пароля --}}
        <div class="form-group">
            <label for="password_confirmation">Подтверждение пароля</label>
            <input type="password"
                   id="password_confirmation"
                   name="password_confirmation"
                   placeholder="Повторите пароль"
                   required>
        </div>

        <button type="submit" id="submitButton">Зарегистрироваться</button>

        <p>Есть аккаунт? <a href="{{ route('login') }}">Вход</a></p>
    </form>
@endsection
