<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;

Route::middleware('auth')->group(function () {
    Route::get('/appointment/{doctor}', [AppointmentController::class, 'show'])
         ->name('appointment.show');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
    
    Route::delete('/appointments', [AppointmentController::class, 'destroyAll'])->name('appointments.destroyAll');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::post('/dashboard/cancel', [DashboardController::class, 'cancel'])->name('dashboard.cancel');
});

Route::middleware('auth')->group(function () {
    Route::get('/doctors', [DoctorController::class, 'index'])->name('doctors.index');

    Route::post('/doctors', [DoctorController::class, 'store'])
         ->middleware('admin')
         ->name('doctors.store');

    Route::delete('/doctors/{doctor}', [DoctorController::class, 'destroy'])
         ->middleware('admin')
         ->name('doctors.destroy');
});

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');

    Route::get('/register', [AuthController::class, 'showRegistrationForm'])
         ->name('register');

    Route::post('/register', [AuthController::class, 'register'])
         ->name('register.attempt');
});

Route::post('/logout', [AuthController::class, 'logout'])
     ->middleware('auth')
     ->name('logout');
