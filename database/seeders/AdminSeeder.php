<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Menghapus data admin lama biar ga dobel kalau dijalankan berkali-kali
        DB::table('admins')->truncate();

        // Menyuntikkan data admin baru
        DB::table('admins')->insert([
            'nama' => 'Administrator SIMARU',
            'email' => 'admin@simaru.com',
            'password' => Hash::make('admin123'), // Password WAJIB di-enkripsi (diacak)
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}