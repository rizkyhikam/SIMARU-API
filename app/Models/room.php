<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Room extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'rooms';
    
    protected $primaryKey = '_id'; 
    protected $keyType = 'string';

    protected $fillable = [
        'nama_ruangan',
        'kapasitas',
        'fasilitas',
        'status',
        'image',
    ];
}