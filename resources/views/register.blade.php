@php
    $title = 'Регистрация';
    $action = route('register.attempt');
    $id = 'registrationForm';
    $script = 'register';
@endphp

@extends('layouts.form')

@section('content')
    <div class="form-group">
        <label for="fullName">ФИО:</label>
        <input type="text" name="fullName" id="fullName" value="{{ old('fullName') }}" class="form-control" required>
        <div id="fullNameError" class="error">@error('fullName'){{ $message }}@enderror</div>
    </div>

    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control" required>
        <div id="emailError" class="error">@error('email'){{ $message }}@enderror</div>
    </div>

    <div class="form-group">
        <label for="password">Пароль:</label>
        <input type="password" name="password" id="password" class="form-control" required>
        <div id="passwordError" class="error">@error('password'){{ $message }}@enderror</div>
    </div>

    <div class="form-group">
        <label for="confirmPassword">Подтверждение пароля:</label>
        <input type="password" name="password_confirmation" id="confirmPassword" class="form-control" required>
        <div id="confirmPasswordError" class="error"></div>
    </div>

    <button type="submit" id="submitButton" class="btn btn-primary btn-block">Зарегистрироваться</button>

    <div class="form-footer mt-3">
        <p>Уже есть аккаунт? <a href="{{ route('login') }}">Войти</a></p>
    </div>
@endsection
