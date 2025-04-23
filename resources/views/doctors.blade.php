@extends('layouts.main')

@section('title', 'Специалисты')
@section('style', 'doctors')
@section('script', 'doctors')

@section('content')
    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    {{-- Форма добавления для админа --}}
    @if(auth()->user()->role === 'admin')
        <form id="newDoctor"
              method="POST"
              action="{{ route('doctors.store') }}"
              enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="fullName">ФИО</label>
                <input type="text" id="fullName" name="fullName"
                       value="{{ old('fullName') }}" required>
                @error('fullName')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="speciality">Специальность</label>
                <input type="text" id="speciality" name="speciality"
                       value="{{ old('speciality') }}" required>
                @error('speciality')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="profilePicture">Фото</label>
                <input type="file" id="profilePicture" name="profilePicture"
                       accept="image/*">
                @error('profilePicture')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" id="submitButton">Добавить</button>
        </form>
    @endif

    {{-- Список врачей --}}
    <div id="doctorsList">
        @forelse($doctors as $doctor)
            <div class="doctor-item" data-id="{{ $doctor->id }}">
                <img src="{{ asset('storage/' . $doctor->profile_picture) }}"
                     class="profile-picture" alt="Фото {{ $doctor->full_name }}">

                <div class="doctor-info">
                    <p><strong>ФИО:</strong> {{ $doctor->full_name }}</p>
                    <p><strong>Специальность:</strong> {{ $doctor->specialty }}</p>
                </div>

                @if(auth()->user()->role === 'admin')
                    <form method="POST"
                          action="{{ route('doctors.destroy', $doctor) }}"
                          onsubmit="return confirm('Вы уверены?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Удалить</button>
                    </form>
                @else
                    <a href="{{ route('appointment.show', $doctor) }}"
                       class="appoint-doctor">
                        Записаться
                    </a>
                @endif
            </div>
        @empty
            <p class="text_message">Врачи не найдены.</p>
        @endforelse
    </div>
@endsection
