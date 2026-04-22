<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\Auth\MahasiswaAuthController;
use App\Http\Controllers\MahasiswaController;
use Illuminate\Support\Facades\Auth;

// --- 1. HALAMAN UTAMA (PORTAL PILIHAN) ---
Route::get('/', function () {
    return view('welcome');
});

// --- 2. AUTH MAHASISWA ---
Route::get('/login/mahasiswa', [MahasiswaAuthController::class, 'showLoginForm'])->name('mahasiswa.login');
Route::post('/login/mahasiswa', [MahasiswaAuthController::class, 'login']);
Route::get('/register/mahasiswa', [MahasiswaAuthController::class, 'showRegisterForm'])->name('mahasiswa.register');
Route::post('/register/mahasiswa', [MahasiswaAuthController::class, 'register']);
Route::post('/logout/mahasiswa', [MahasiswaAuthController::class, 'logout'])->name('mahasiswa.logout');

// --- 3. AUTH ADMIN ---
Route::get('/login/admin', function () {
    return view('admin-login');
})->name('login');

Route::post('/login/admin/proses', [AdminAuthController::class, 'cekLogin'])->name('admin.login.proses');

// --- 4. AREA TERPROTEKSI ADMIN (WAJIB LOGIN ADMIN) ---
Route::middleware('auth:admin')->group(function () {
    
    // Pintu Utama Setelah Login (Langsung ke Menu Kartu-Kartu)
    Route::get('/dashboard', function () {
        return view('admin-menu'); 
    })->name('dashboard');

    // Menu Utama (Alias)
    Route::get('/menu/admin', function () {
        return view('admin-menu');
    })->name('admin.menu');

    // Halaman Statistik (Biru Navy)
    Route::get('/dashboard/admin', function () {
        return view('admin-dashboard');
    })->name('admin.dashboard');

    // --- KELOLA RUANGAN ---
    Route::get('/ruangan/admin', [RoomController::class, 'index'])->name('admin.ruangan');
    Route::post('/ruangan/admin/simpan', [AdminAuthController::class, 'simpanRuangan'])->name('admin.ruangan.simpan');
    Route::delete('/ruangan/admin/hapus/{id}', [AdminAuthController::class, 'hapusRuangan'])->name('admin.ruangan.hapus');
    Route::put('/ruangan/admin/update/{id}', [AdminAuthController::class, 'updateRuangan'])->name('admin.ruangan.update');

    // --- KELOLA PEMINJAMAN ---
    Route::get('/peminjaman/admin', [AdminAuthController::class, 'halamanPeminjaman'])->name('admin.peminjaman');
    Route::put('/peminjaman/admin/update-status/{id}', [AdminAuthController::class, 'updateStatusPeminjaman'])->name('admin.peminjaman.update');

    // --- KELOLA PENGGUNA/ADMIN ---
    Route::get('/pengguna/admin', function () {
        return view('admin-pengguna');
    })->name('admin.pengguna');
    Route::post('/pengguna/admin/simpan', [AdminAuthController::class, 'simpanAdmin'])->name('admin.simpan_admin');
    Route::delete('/pengguna/admin/hapus/{id}', [AdminAuthController::class, 'hapusAdmin'])->name('admin.hapus_admin');

    // --- LOGOUT ADMIN ---
    Route::post('/logout/admin', function () {
        Auth::guard('admin')->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/login/admin');
    })->name('admin.logout');
});

// --- 5. AREA TERPROTEKSI MAHASISWA ---
Route::middleware('auth')->group(function () {
    Route::get('/dashboard/mahasiswa', [MahasiswaController::class, 'index'])->name('mahasiswa.dashboard');

    // Halaman Riwayat Peminjaman
    Route::get('/peminjaman/mahasiswa', [MahasiswaController::class, 'riwayatPeminjaman'])->name('mahasiswa.peminjaman');
    
    // Proses Simpan Booking dari Modal
    Route::post('/peminjaman/ajukan', [MahasiswaController::class, 'ajukanPeminjaman'])->name('peminjaman.ajukan');

    // Halaman Profil
    Route::get('/profil/mahasiswa', [MahasiswaController::class, 'profil'])->name('mahasiswa.profil');
});