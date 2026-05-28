<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Room;

class PeminjamanController extends Controller
{
    // Balikin ke isi awal lu yang ini aja bray, biar aman 100%
    public function updateStatus(Request $request, $id)
    {
        $pinjam = Peminjaman::find($id);
        
        if (!$pinjam) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan']);
        }

        $pinjam->status = $request->status;
        $pinjam->save();

        if ($request->status == 'Disetujui') {
            $ruangan = Room::where('nama_ruangan', $pinjam->room_name)->first();
            if ($ruangan) {
                $ruangan->status = 'Dipakai';
                $ruangan->save();
            }
        }

        return response()->json(['success' => true]);
    }
}