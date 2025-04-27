@php
    $title = 'Регистрация';
    $action = route('register');
    $id = 'register-form';
    $script = 'register';
@endphp

@extends('layouts.form')

@section('content')
    <div class="form-group">
        <label for="full_name">ФИО:</label>
        <input type="text" name="full_name" id="full_name" value="{{ old('full_name') }}" class="form-control" required>
        @error('full_name')
            <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control" required>
        @error('email')
            <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="phone">Телефон:</label>
        <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" class="form-control" required>
        @error('phone')
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

    <div class="form-group">
        <label for="password_confirmation">Подтверждение пароля:</label>
        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary btn-block">Зарегистрироваться</button>

    <div class="form-footer mt-3">
        <p>Уже есть аккаунт? <a href="{{ route('login') }}">Войти</a></p>
    </div>
@endsection
