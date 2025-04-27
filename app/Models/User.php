<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'full_name',
        'email',
        'password',
        'gender',
        'birth_date',
        'role',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];
    
    
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
}
