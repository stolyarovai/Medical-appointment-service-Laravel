<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = [
        'user_id', 'doctor_id', 'appointment_date', 'appointment_time', 'status'
    ];
}
