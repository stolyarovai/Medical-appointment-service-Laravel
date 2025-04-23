<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = [
        'full_name', 'specialty', 'profile_picture'
    ];
}
