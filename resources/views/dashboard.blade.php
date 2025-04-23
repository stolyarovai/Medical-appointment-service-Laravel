@extends('layouts.main')

@section('title', 'Личный кабинет')
@section('style', 'dashboard')
@section('script', 'dashboard')

@section('content')
    <h1>Доброго времени суток, {{ $user->full_name }}!</h1>

    <div class="personal_data">
        <p>
            <strong>Пол:</strong>
            {{ $user->gender === 'male' ? 'Мужской' : ($user->gender === 'female' ? 'Женский' : 'Не определён') }}
            <button id="edit-gender-btn">Изменить</button>
        </p>
        <p>
            <strong>Дата рождения:</strong>
            <span id="birth-date-text">{{ $birth }}</span>
            <button id="edit-birth-date-btn">Изменить</button>
        </p>
        <p>
            <strong>Email:</strong> {{ $user->email }}
        </p>
    </div>

    <h2>Активные записи</h2>
    @if($active->isEmpty())
        <p class="text_message">Активных записей нет.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Дата</th>
                    <th>Время</th>
                    <th>Врач</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
            @foreach($active as $appt)
                <tr data-id="{{ $appt->id }}">
                    <td>{{ $appt->appointment_date->format('Y-m-d') }}</td>
                    <td>{{ $appt->appointment_time }}</td>
                    <td>{{ $appt->doctor->full_name }}</td>
                    <td>
                        <button class="cancel-btn" data-id="{{ $appt->id }}">Отменить</button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif

    <h2>Старые записи</h2>
    @if($old->isEmpty())
        <p class="text_message">Старых записей нет.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Дата</th>
                    <th>Время</th>
                    <th>Врач</th>
                </tr>
            </thead>
            <tbody>
            @foreach($old as $appt)
                <tr>
                    <td>{{ $appt->appointment_date->format('Y-m-d') }}</td>
                    <td>{{ $appt->appointment_time }}</td>
                    <td>{{ $appt->doctor->full_name }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
@endsection
