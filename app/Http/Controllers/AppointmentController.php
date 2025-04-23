<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function show(Doctor $doctor)
    {
        return view('appointment', [
            'doctor'   => $doctor,
        ]);
    }
}
