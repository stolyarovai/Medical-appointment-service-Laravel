<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with(['user', 'doctor'])
            ->orderBy('appointment_time')
            ->get();

        return view('appointments', [
            'appointments' => $appointments,
        ]);
    }

    public function destroyAll(Request $request)
    {
        Appointment::query()->delete();

        return redirect()->route('appointments.index')
                         ->with('status', 'Все назначения удалены.');
    }
}