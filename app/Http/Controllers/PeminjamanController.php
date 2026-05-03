<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Room;

class PeminjamanController extends Controller
{
    public function updateStatus(Request $request, $id)
    {
        // 1. Cari data peminjamannya
        $pinjam = Peminjaman::find($id);
        
        if (!$pinjam) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan']);
        }

        $pinjam->status = $request->status; // 'Disetujui' atau 'Ditolak'
        $pinjam->save();

        // 2. Kalo disetujui, otomatis ganti status ruangannya bray
        if ($request->status == 'Disetujui') {
            $ruangan = Room::where('nama_ruangan', $pinjam->room_name)->first();
            if ($ruangan) {
                $ruangan->status = 'Dipakai'; // Ruangan jadi ga tersedia otomatis
                $ruangan->save();
            }
        }

        return response()->json(['success' => true]);
    }
}