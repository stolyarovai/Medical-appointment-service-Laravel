<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = [
        'full_name',
        'email',
        'password_hash',
        'gender',
        'birth_date',
        'role',
    ];
    
    protected $hidden = ['password_hash', 'remember_token'];
}
