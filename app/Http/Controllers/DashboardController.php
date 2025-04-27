<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $displayBirthDate = optional($user->birth_date)
            ? Carbon::parse($user->birth_date)
                    ->locale('ru')
                    ->isoFormat('D MMMM YYYY г.')
            : null;

        $active = Appointment::with('doctor')
            ->where('user_id', $user->id)
            ->where('status', 'scheduled')
            ->orderBy('appointment_date')
            ->get();

        $old = Appointment::with('doctor')
            ->where('user_id', $user->id)
            ->whereIn('status', ['completed', 'cancelled'])
            ->orderByDesc('appointment_date')
            ->get();

        return view('dashboard', [
            'user'    => $user,
            'active'  => $active,
            'old'     => $old,
            'birth'   => $displayBirthDate,
        ]);
    }

    public function cancel(Request $request)
    {
        $request->validate([
            'appointment_id' => 'required|integer|exists:appointments,id',
        ]);

        $user = Auth::user();
        $appt = Appointment::where('id', $request->appointment_id)
                           ->where('user_id', $user->id)
                           ->firstOrFail();

        $limit = Carbon::parse($appt->appointment_date)->subDay();
        if (Carbon::now()->gt($limit)) {
            return response()->json([
                'success' => false,
                'error'   => 'Запись можно отменить не позднее, чем за 1 день до приёма.'
            ]);
        }

        $appt->status = 'cancelled';
        $appt->save();

        return response()->json(['success' => true]);
    }
}
