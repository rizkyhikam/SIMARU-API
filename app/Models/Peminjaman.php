<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Peminjaman extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'peminjamans';

    protected $fillable = [
        'user_id',      // ID Mahasiswa
        'user_name',    // Nama Mahasiswa
        'room_id',      // ID Ruangan
        'room_name',    // Nama Ruangan
        'tanggal',
        'jam_mulai',    // Jam mulai pinjam
        'jam_selesai',  // Jam selesai pinjam
        'status'
    ];
}