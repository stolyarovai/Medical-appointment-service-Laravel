<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Doctor;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function show(Doctor $doctor)
    {
        return view('appointment', [
            'doctor'   => $doctor,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'doctor_id'       => 'required|integer|exists:doctors,id',
            'appointment_date'=> 'required|date|after_or_equal:today',
            'appointment_time'=> 'required|date_format:H:i',
        ]);

        $appointment = Appointment::create([
            'user_id'           => Auth::id(),
            'doctor_id'         => $data['doctor_id'],
            'appointment_date'  => $data['appointment_date'],
            'appointment_time'  => $data['appointment_time'],
            'status'            => 'active',
        ]);

        return response()->json([
            'success'  => true,
            'redirect' => route('dashboard'),
        ]);
    }

    public function destroyAll(Request $request)
    {
        Appointment::query()->delete();

        return response()->json(['success' => true]);
    }

    public function availability(Request $request)
    {
        $data = $request->validate([
            'doctor_id' => 'required|integer|exists:doctors,id',
            'date'      => 'required|date',
        ]);

        $times = [];
        $start = Carbon::createFromTime(9, 0);
        $end   = Carbon::createFromTime(18, 0);

        for ($time = $start->copy(); $time->lt($end); $time->addMinutes(15)) {
            if ($time->hour === 13) {
                $time->addHour()->minute(0);
                if ($time->gte($end)) break;
            }
            $times[] = $time->format('H:i');
        }

        $booked = Appointment::where('doctor_id', $data['doctor_id'])
            ->whereDate('appointment_date', $data['date'])
            ->where('status', 'active')
            ->pluck('appointment_time')
            ->map(fn($t) => substr($t, 0, 5))
            ->toArray();

        $available = array_values(array_diff($times, $booked));

        return response()->json([
            'success'   => true,
            'available' => $available,
            'booked'    => $booked,
        ]);
    }
}
