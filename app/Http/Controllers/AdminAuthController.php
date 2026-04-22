<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Room;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminAuthController extends Controller
{
    public function cekLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/menu/admin');
        }

        return back()->withErrors(['email' => 'Login Gagal! Akun gak ketemu di tabel Admin.']);
    }

    public function hapusRuangan($id)
    {
        try {
            $room = Room::where('_id', $id)->first();
            if ($room) {
                if ($room->image && Storage::disk('public')->exists($room->image)) {
                    Storage::disk('public')->delete($room->image);
                }
                $room->delete();
                return response()->json(['success' => true]);
            }
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function simpanRuangan(Request $request)
    {
        $request->validate([
            'nama_ruangan' => 'required',
            'kapasitas' => 'required',
            'fasilitas'    => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('rooms', 'public');
        }

        Room::create([
            'nama_ruangan' => $request->nama_ruangan,
            'kapasitas' => $request->kapasitas,
            'fasilitas' => $request->fasilitas,
            'status' => 'Tersedia',
            'image' => $path, 
        ]);

        return response()->json(['success' => true]);
    }

    public function updateRuangan(Request $request, $id)
    {
        $room = Room::where('_id', $id)->first();
        if ($room) {
            $data = [
                'nama_ruangan' => $request->nama_ruangan,
                'kapasitas'    => (int) $request->kapasitas,
                'fasilitas'    => $request->fasilitas,
            ];

            if ($request->hasFile('image')) {
                if ($room->image) {
                    Storage::disk('public')->delete($room->image);
                }
                $path = $request->file('image')->store('rooms', 'public');
                $data['image'] = $path;
            }

            $room->update($data);
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false, 'message' => 'Gagal update data!']);
    }

public function updateStatusPeminjaman(Request $request, $id)
{
    try {
        $peminjaman = \App\Models\Peminjaman::where('_id', $id)->first();
        
        if ($peminjaman) {
            $peminjaman->update([
                'status' => $request->status // Disetujui atau Ditolak
            ]);
            return response()->json(['success' => true]);
        }
        
        return response()->json(['success' => false, 'message' => 'Data tidak ditemukan']);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => $e->getMessage()]);
    }
}

    public function halamanPeminjaman()
    {
        try {
            $peminjamans = \App\Models\Peminjaman::all(); 
        } catch (\Exception $e) {
            $peminjamans = collect();
        }
        return view('admin-peminjaman', compact('peminjamans'));
    }

    public function hapusPengguna($id)
    {
        try {
            $user = User::find($id);
            if ($user) {
                $user->delete();
                return response()->json(['success' => true]);
            }
            return response()->json(['success' => false, 'message' => 'User gagal ditemukan']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function hapusAdmin($id)
    {
        $admin = Admin::find($id);
        if ($admin) {
            $admin->delete();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false, 'message' => 'Admin tidak ditemukan']);
    }

    public function simpanAdmin(Request $request)
    {
        try {
            Admin::create([
                'nama' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal tambah admin!']);
        }
    }
}