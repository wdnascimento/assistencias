<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Professor extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $fillable = [
        'name', 'email',  'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
