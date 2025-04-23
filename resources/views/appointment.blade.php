@extends('layouts.main') {{-- ваш главный layout, например resources/views/layouts/main.blade.php --}}

@section('title', 'Запись к врачу')
@section('style', 'appointment')
@section('script', 'appointment')

@section('content')
    <h1>Запись к врачу</h1>

    <img class="doctor-image" src="{{ asset('profile_pictures/' . $doctor->profile_picture) }}"
         alt="Фото врача {{ $doctor->full_name }}">

    <p><b>{{ $doctor->specialty }}</b> {{ $doctor->full_name }}</p>

    <form id="appointment-form">
        @csrf {{-- Laravel‑токен --}}
        <label for="date">Дата:</label>
        <input type="date" name="date" id="date">

        <input type="hidden" name="doctor_id" value="{{ $doctor->id }}">
    </form>

    <div class="time-container"></div>
    <p class="text_message"></p>
@endsection
