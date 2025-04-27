@extends('layouts.main')

@section('title', 'Личный кабинет')
@section('style', 'dashboard')
@section('script', 'dashboard')

@section('content')
    <div class="dashboard-header">
        <h1>Доброго времени суток, {{ $user->full_name }}!</h1>
    </div>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm personal-data-card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Персональные данные</h5>
                </div>
                <div class="card-body">
                    <div class="personal-data-item">
                        <strong>Пол:</strong>
                        <span id="gender-text">{{ $user->gender === 'male' ? 'Мужской' : ($user->gender === 'female' ? 'Женский' : 'Не указан') }}</span>
                        <button id="edit-gender-btn" class="btn btn-sm btn-outline-primary">Изменить</button>
                    </div>
                    <div class="personal-data-item">
                        <strong>Дата рождения:</strong>
                        <span id="birth-date-text" data-date="{{ $user->birth_date ?? '' }}">{{ $birth ?? 'Не указана' }}</span>
                        <button id="edit-birth-date-btn" class="btn btn-sm btn-outline-primary">Изменить</button>
                    </div>
                    <div class="personal-data-item">
                        <strong>Email:</strong> {{ $user->email }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 mb-4">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Активные записи</h5>
                </div>
                <div class="card-body">
                    @if($active->isEmpty())
                        <p class="text-muted text-center">Активных записей нет.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover appointments-table">
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
                                        <td>{{ $appt->appointment_date->format('d.m.Y') }}</td>
                                        <td>{{ $appt->appointment_date->format('H:i') }}</td>
                                        <td>{{ $appt->doctor->full_name }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-danger cancel-btn" data-id="{{ $appt->id }}">Отменить</button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="card-title mb-0">Старые записи</h5>
                </div>
                <div class="card-body">
                    @if($old->isEmpty())
                        <p class="text-muted text-center">Старых записей нет.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover appointments-table">
                                <thead>
                                    <tr>
                                        <th>Дата</th>
                                        <th>Время</th>
                                        <th>Врач</th>
                                        <th>Статус</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($old as $appt)
                                    <tr>
                                        <td>{{ $appt->appointment_date->format('d.m.Y') }}</td>
                                        <td>{{ $appt->appointment_date->format('H:i') }}</td>
                                        <td>{{ $appt->doctor->full_name }}</td>
                                        <td>
                                            <span class="badge {{ $appt->status === 'completed' ? 'bg-success' : 'bg-secondary' }}">
                                                {{ $appt->status === 'completed' ? 'Завершена' : 'Отменена' }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
