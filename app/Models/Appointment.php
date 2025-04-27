<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Appointment extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id', 
        'doctor_id', 
        'appointment_time', 
        'status',
        'notes'
    ];

    protected $casts = [
        'appointment_time' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
