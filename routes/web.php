<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.attempt');
});

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/doctors/json', [DoctorController::class, 'all'])->name('doctors.all');
Route::post('/validate-email', [UserController::class, 'validateEmail'])->name('validate.email');

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/cancel', [DashboardController::class, 'cancel'])->name('dashboard.cancel');
    Route::get('/doctors', [DoctorController::class, 'index'])->name('doctors.index');
    Route::get('/appointment/{doctor}', [AppointmentController::class, 'show'])->name('appointment.show');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::get('/appointments/availability', [AppointmentController::class, 'availability'])->name('appointments.availability');
    Route::post('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update');

    Route::middleware('admin')->group(function () {
        Route::post('/doctors', [DoctorController::class, 'store'])->name('doctors.store');
        Route::post('/doctors/{doctor}/icon', [DoctorController::class, 'updateIcon'])->name('doctors.updateIcon');
        Route::delete('/doctors/{doctor}', [DoctorController::class, 'destroy'])->name('doctors.destroy');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
        Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
        Route::delete('/appointments', [AppointmentController::class, 'destroyAll'])->name('appointments.destroyAll');
    });
});