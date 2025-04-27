@extends('layouts.main')

@section('title', 'Специалисты')
@section('style', 'doctors')
@section('script', 'doctors')

@section('content')
    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    @if(auth()->check() && auth()->user()->role === 'admin')
        <form id="newDoctor"
              method="POST"
              action="{{ route('doctors.store') }}"
              enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="fullName">ФИО</label>
                <input type="text" id="fullName" name="fullName"
                       value="{{ old('fullName') }}" required>
                <div class="error" id="fullNameError">
                    @error('fullName'){{ $message }}@enderror
                </div>
            </div>

            <div class="form-group">
                <label for="specialty">Специальность</label>
                <input type="text" id="specialty" name="specialty"
                       value="{{ old('specialty') }}" required>
                <div class="error" id="specialtyError">
                    @error('specialty'){{ $message }}@enderror
                </div>
            </div>

            <div class="form-group">
                <label for="profilePicture">Фото</label>
                <input type="file" id="profilePicture" name="profilePicture"
                       accept="image/*">
                <div class="error" id="profilePictureError">
                    @error('profilePicture'){{ $message }}@enderror
                </div>
            </div>

            <button type="submit" id="submitButton">Добавить</button>
            <div class="error" id="Error"></div>
        </form>
    @endif

    <div id="doctorsList">
        @forelse($doctors as $doctor)
            @include('partials.doctor-item', ['doctor' => $doctor])
        @empty
            <p class="text_message">Врачи не найдены.</p>
        @endforelse
    </div>
@endsection
