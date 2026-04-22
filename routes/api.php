<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController; // Pake yang ini aja bray biar kodingannya nyambung

// 1. Ambil semua ruangan (Buat tampilan awal di HP)
Route::get('/rooms', [MahasiswaController::class, 'apiGetRooms']);

// 2. Ambil jadwal terisi (Biar di HP juga kelihatan jam mana yang udah dibooking)
Route::get('/schedules', [MahasiswaController::class, 'apiGetSchedules']);

// 3. Login Mahasiswa (Nanti buat dapet Token)
// Route::post('/login', [MahasiswaAuthController::class, 'apiLogin']);