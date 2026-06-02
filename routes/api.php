<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\ApiController;

// ============================================================
// PUBLIC — Tidak perlu login
// ============================================================

// Ambil semua ruangan
Route::get('/rooms', [MahasiswaController::class, 'apiGetRooms']);

// Ambil semua jadwal aktif
Route::get('/schedules', [MahasiswaController::class, 'apiGetSchedules']);

// ============================================================
// AUTH — Login & Register (public, tidak perlu token)
// ============================================================

// Login Mahasiswa → dapat token
Route::post('/login', [ApiController::class, 'loginMahasiswa']);

// Login Admin → dapat token
Route::post('/login/admin', [ApiController::class, 'loginAdmin']);

// Register Mahasiswa baru
Route::post('/register', [ApiController::class, 'registerMahasiswa']);

// ============================================================
// PROTECTED — Semua endpoint ini membutuhkan Bearer token
// Token dikirim dari Android di header: Authorization: Bearer {token}
// Validasi token dilakukan langsung di ApiController
// ============================================================

// --- Peminjaman Mahasiswa ---
Route::post('/peminjaman/ajukan', [ApiController::class, 'ajukanPeminjaman']);
Route::get('/peminjaman/riwayat', [ApiController::class, 'riwayatPeminjaman']);
Route::post('/user/update-photo', [ApiController::class, 'updatePhoto']);

// --- Admin: Ruangan ---
Route::post('/ruangan/simpan', [ApiController::class, 'simpanRuangan']);
Route::put('/ruangan/update/{id}', [ApiController::class, 'updateRuangan']);
Route::post('/ruangan/update/{id}', [ApiController::class, 'updateRuangan']); // fallback POST (PHP multipart PUT fix)
Route::delete('/ruangan/hapus/{id}', [ApiController::class, 'hapusRuangan']);

// --- Admin: Peminjaman ---
Route::put('/peminjaman/update-status/{id}', [ApiController::class, 'updateStatusPeminjaman']);

// --- Admin: Pengguna ---
Route::get('/admin/pengguna', [ApiController::class, 'getDaftarAdmin']);
Route::delete('/pengguna/hapus/{id}', [ApiController::class, 'hapusAdmin']);