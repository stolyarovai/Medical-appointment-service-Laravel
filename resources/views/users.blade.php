@extends('layouts.main')

@section('title', 'Пользователи')
@section('style', 'users')
@section('script', 'users')

@section('content')
    <h1>Список пользователей</h1>
    
    @if($users->isEmpty())
        <p class="text_message">Пользователи не найдены.</p>
    @else
        <div id="usersList">
            @foreach($users as $user)
                <div class="user-item" data-id="{{ $user->id }}">
                    <div class="user-info">
                        <h3>{{ $user->full_name }}</h3>
                        <p><strong>Email:</strong> {{ $user->email }}</p>
                        <p><strong>Пол:</strong> {{ $user->gender === 'male' ? 'Мужской' : ($user->gender === 'female' ? 'Женский' : 'Не указан') }}</p>
                        <p><strong>Дата рождения:</strong> {{ $user->birth_date ? date('d.m.Y', strtotime($user->birth_date)) : 'Не указана' }}</p>
                        
                        <button class="delete-user" data-id="{{ $user->id }}">Забанить</button>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection 