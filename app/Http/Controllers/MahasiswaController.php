<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;

class MahasiswaController extends Controller
{
    public function index(Request $request)
{
    $rooms = Room::all();
    
    // Membaca tanggal filter pilihan user, kalau kosong auto nembak tanggal hari ini bray
    $tanggalPilihan = $request->input('filter_date', date('Y-m-d'));

    $all_peminjaman = Peminjaman::whereIn('status', ['Pending', 'Disetujui'])
                        ->where('tanggal', $tanggalPilihan) 
                        ->get();

    return view('mahasiswa.dashboard', compact('rooms', 'all_peminjaman'));
}

    public function riwayatPeminjaman()
    {
        $peminjamans = Peminjaman::where('user_id', Auth::id())->get();
        return view('mahasiswa.peminjaman', compact('peminjamans'));
    }

    public function profil() 
    {
        $user = Auth::user();
        $stats = [
            'disetujui' => Peminjaman::where('user_id', $user->id)->where('status', 'Disetujui')->count(),
            'menunggu'  => Peminjaman::where('user_id', $user->id)->where('status', 'Pending')->count(),
            'ditolak'   => Peminjaman::where('user_id', $user->id)->where('status', 'Ditolak')->count(),
        ];
        return view('mahasiswa.profil', compact('user', 'stats'));
    }

    public function ajukanPeminjaman(Request $request)
    {
        $request->validate([
            'room_id' => 'required',
            'tanggal' => 'required|date',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'ktm' => 'required|file|mimes:jpeg,png,jpg,pdf|max:2048', // Validasi file KTM
        ]);

        $bentrok = Peminjaman::where('room_id', $request->room_id)
            ->where('tanggal', $request->tanggal)
            ->whereIn('status', ['Pending', 'Disetujui'])
            ->where(function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('jam_mulai', '<', $request->jam_selesai)
                      ->where('jam_selesai', '>', $request->jam_mulai);
                });
            })->exists();

        if ($bentrok) {
            return response()->json([
                'success' => false, 
                'message' => 'Maaf, ruangan sudah dipesan pada jam tersebut. Silakan pilih jadwal lain.'
            ]);
        }

        try {
            // Logika upload KTM diselipin di sini sebelum create ke DB
            $pathKtm = null;
            if ($request->hasFile('ktm')) {
                $pathKtm = $request->file('ktm')->store('ktm_mahasiswa', 'public');
            }

            Peminjaman::create([
                'user_id' => auth()->id(),
                'user_name' => auth()->user()->name,
                'room_id' => $request->room_id,
                'room_name' => $request->room_name,
                'tanggal' => $request->tanggal,
                'jam_mulai' => $request->jam_mulai,
                'jam_selesai' => $request->jam_selesai,
                'status' => 'Pending',
                'file_ktm' => $pathKtm, // Path file KTM masuk ke field database
            ]);

            return response()->json(['success' => true, 'message' => 'Pengajuan berhasil dikirim secara resmi.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }


    public function apiGetRooms()
    {
        $rooms = Room::all()->map(function($room) {
            return [
                'id'           => (string) $room->_id,
                '_id'          => (string) $room->_id,
                'nama_ruangan' => $room->nama_ruangan,
                'kapasitas'    => (int) $room->kapasitas,
                'fasilitas'    => $room->fasilitas,
                'status'       => $room->status,
                'image'        => $room->image,
                'image_url'    => $room->image ? url('storage/' . $room->image) : 'https://via.placeholder.com/400x280?text=No+Image',
                'created_at'   => $room->created_at ? $room->created_at->toDateTimeString() : null,
                'updated_at'   => $room->updated_at ? $room->updated_at->toDateTimeString() : null,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $rooms
        ]);
    }

    public function apiGetSchedules()
    {
        $schedules = Peminjaman::orderBy('created_at', 'desc')->get()->map(function($p) {
            return [
                'id'          => (string) $p->_id,
                '_id'         => (string) $p->_id,
                'user_id'     => $p->user_id,
                'user_name'   => $p->user_name,
                'room_id'     => $p->room_id,
                'room_name'   => $p->room_name,
                'tanggal'     => $p->tanggal,
                'jam_mulai'   => $p->jam_mulai,
                'jam_selesai' => $p->jam_selesai,
                'status'      => $p->status,
                'file_ktm'    => $p->file_ktm,
                'created_at'  => $p->created_at ? $p->created_at->toDateTimeString() : null,
                'updated_at'  => $p->updated_at ? $p->updated_at->toDateTimeString() : null,
            ];
        });
        
        return response()->json([
            'success' => true,
            'data'    => $schedules
        ]);
    }
}