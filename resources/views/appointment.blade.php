@extends('layouts.main') {{-- ваш главный layout, например resources/views/layouts/main.blade.php --}}

@section('title', 'Запись к врачу')
@section('style', 'appointment')
@section('script', 'appointment')

@section('content')
    <h1>Запись к врачу</h1>

    <img class="doctor-image" src="{{ $doctor->profile_picture ? asset('storage/'.$doctor->profile_picture) : asset('images/none.png') }}"
         alt="Фото врача {{ $doctor->full_name }}">

    <p><b>{{ $doctor->specialty ?: $doctor->specialization }}</b> {{ $doctor->full_name }}</p>

    <form id="appointment-form">
        @csrf {{-- Laravel‑токен --}}
        <label for="date">Дата:</label>
        <input type="date" name="date" id="date" min="{{ date('Y-m-d') }}">

        <input type="hidden" name="doctor_id" value="{{ $doctor->id }}">
    </form>

    <div class="time-container"></div>
    <p class="text_message"></p>
@endsection
