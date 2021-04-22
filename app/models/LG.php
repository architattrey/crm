<?php

namespace App\models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class LG extends Authenticatable
{
    use Notifiable;

    protected $guard = 'lg';
    protected $table = 'lg';
    public $timestamps = false;
    protected $primaryKey = 'id';

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}