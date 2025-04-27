@php
    $title = 'Вход';
    $action = route('login');
    $id = 'login-form';
    $script = 'login';
@endphp

@extends('layouts.form')

@section('content')
    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control" required>
        @error('email')
            <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="password">Пароль:</label>
        <input type="password" name="password" id="password" class="form-control" required>
        @error('password')
            <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-check">
        <input type="checkbox" name="remember" id="remember" class="form-check-input" {{ old('remember') ? 'checked' : '' }}>
        <label for="remember" class="form-check-label">Запомнить меня</label>
    </div>

    <button type="submit" class="btn btn-primary btn-block">Войти</button>

    <div class="form-footer mt-3">
        <p>Нет аккаунта? <a href="{{ route('register') }}">Зарегистрироваться</a></p>
    </div>
@endsection
