<?php

namespace App\Models;

// WAJIB PAKE YANG INI KAM!
use MongoDB\Laravel\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $connection = 'mongodb';
    protected $collection = 'users';

    protected $fillable = [
        'name', 'email', 'password', 'role', 'nim'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    // Tambahkan ini biar Laravel nggak bingung nyari kolom password
    public function getAuthPassword()
    {
        return $this->password;
    }
}