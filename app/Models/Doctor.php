<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'specialization',
        'specialty',
        'bio',
        'email',
        'phone',
        'profile_picture'
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
