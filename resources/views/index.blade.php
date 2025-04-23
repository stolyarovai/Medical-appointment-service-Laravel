@extends('layouts.main')

@section('title', 'Главная страница')
@section('style', 'index')
@section('script', 'index')

@section('content')
    <h1>Добро пожаловать на сайт "Будь здоров!"</h1>
    <p>Этот сервис поможет вам записаться на приём к врачу быстро и удобно.</p>

    <h2>Список доступных врачей</h2>

    <div id="carousel-wrapper">
        <button id="prev">←</button>
        <div id="carousel-container">
            <p>Загрузка...</p>
        </div>
        <button id="next">→</button>
    </div>
@endsection
