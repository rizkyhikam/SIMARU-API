<?php

namespace App\Models;

use MongoDB\Laravel\Auth\User as Authenticatable; 
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $connection = 'mongodb';
    protected $collection = 'admins'; 

    protected $fillable = ['nama', 'email', 'password'];
    protected $hidden = ['password'];
}