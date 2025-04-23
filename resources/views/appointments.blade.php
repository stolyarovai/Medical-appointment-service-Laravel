@extends('layouts.main')

@section('title', 'Список назначений')
@section('style', 'appointments_list')
@section('script', 'appointments_list')

@section('content')
    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    @if($appointments->isEmpty())
        <p class="text_message">Назначения не найдены.</p>
    @else
        <div id="appointmentsList">
            @foreach($appointments as $appt)
                <div class="appointment-item" data-id="{{ $appt->id }}">
                    <div class="appointment-info">
                        <p><strong>Пациент:</strong> {{ $appt->user->full_name }}</p>
                        <p><strong>Врач:</strong> {{ $appt->doctor->full_name }}</p>
                        <p><strong>Дата:</strong> {{ $appt->appointment_date->format('Y-m-d') }}</p>
                        <p><strong>Время:</strong> {{ $appt->appointment_time }}</p>
                        <p><strong>Статус:</strong>
                            {{ $appt->status === 'active' ? 'Активно' : 'Отменено' }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>

        <form method="POST" action="{{ route('appointments.destroyAll') }}" id="deleteAllForm">
            @csrf
            @method('DELETE')
            <button type="submit" id="deleteAllButton">Удалить все назначения</button>
        </form>
    @endif
@endsection
