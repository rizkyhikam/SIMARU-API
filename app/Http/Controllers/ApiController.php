<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Admin;
use App\Models\Room;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

/**
 * ApiController — menangani semua request dari Android (SIMARU Mobile).
 *
 * Menggunakan token-based auth sederhana: token disimpan di field 'api_token'
 * pada model User/Admin (tanpa Sanctum agar kompatibel dengan MongoDB).
 *
 * Response selalu JSON: { success: true/false, message: "...", data: {...} }
 */
class ApiController extends Controller
{
    // =========================================================================
    // AUTH MAHASISWA
    // =========================================================================

    /**
     * POST /api/login
     * Body: { email, password }
     * Response: { success, token, user: { _id, name, email, nim, role } }
     */
    public function loginMahasiswa(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau kata sandi yang Anda masukkan salah.'
            ], 401);
        }

        // Generate token sederhana dan simpan ke DB
        $token = bin2hex(random_bytes(32));
        $user->api_token = $token;
        $user->save();

        return response()->json([
            'success' => true,
            'token'   => $token,
            'user'    => [
                '_id'   => (string) $user->_id,
                'name'  => $user->name,
                'email' => $user->email,
                'nim'   => $user->nim ?? '-',
                'role'  => $user->role ?? 'mahasiswa',
                'photo' => $user->photo ? url('storage/' . $user->photo) : null,
            ]
        ]);
    }

    /**
     * POST /api/login/admin
     * Body: { email, password }
     * Response: { success, token, user: { _id, name/nama, email, role } }
     */
    public function loginAdmin(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $admin = Admin::where('email', $request->email)->first();

        if (!$admin || !Hash::check($request->password, $admin->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau password admin salah.'
            ], 401);
        }

        // Generate token dan simpan
        $token = bin2hex(random_bytes(32));
        $admin->api_token = $token;
        $admin->save();

        return response()->json([
            'success' => true,
            'token'   => $token,
            'user'    => [
                '_id'   => (string) $admin->_id,
                'name'  => $admin->nama,
                'nama'  => $admin->nama,
                'email' => $admin->email,
                'role'  => 'admin',
            ]
        ]);
    }

    /**
     * POST /api/register
     * Body: { name, email, password, password_confirmation, nim? }
     * Response: { success, message }
     */
    public function registerMahasiswa(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'mahasiswa',
            'nim'      => $request->nim ?? '-',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Akun berhasil dibuat. Silakan login.'
        ]);
    }

    /**
     * POST /api/user/update-photo  (Bearer token mahasiswa)
     * Multipart: photo (file)
     * Response: { success, message, photo_url }
     */
    public function updatePhoto(Request $request)
    {
        $user = $this->getUserFromToken($request);
        if (!$user) return $this->unauthorized();

        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $path = $request->file('photo')->store('profile_photos', 'public');
            $user->photo = $path;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Foto profil berhasil diperbarui!',
                'photo_url' => url('storage/' . $path)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    // =========================================================================
    // HELPER — validasi token dari header Authorization: Bearer {token}
    // =========================================================================

    private function getUserFromToken(Request $request)
    {
        $token = $request->bearerToken();
        if (!$token) return null;
        return User::where('api_token', $token)->first();
    }

    private function getAdminFromToken(Request $request)
    {
        $token = $request->bearerToken();
        if (!$token) return null;
        return Admin::where('api_token', $token)->first();
    }

    private function unauthorized()
    {
        return response()->json([
            'success' => false,
            'message' => 'Tidak terautentikasi. Silakan login terlebih dahulu.'
        ], 401);
    }

    // =========================================================================
    // PEMINJAMAN MAHASISWA
    // =========================================================================

    /**
     * POST /api/peminjaman/ajukan  (Bearer token mahasiswa)
     * Multipart: room_id, room_name, tanggal, jam_mulai, jam_selesai, ktm (file)
     */
    public function ajukanPeminjaman(Request $request)
    {
        $user = $this->getUserFromToken($request);
        if (!$user) return $this->unauthorized();

        $request->validate([
            'room_id'     => 'required',
            'tanggal'     => 'required',
            'jam_mulai'   => 'required',
            'jam_selesai' => 'required',
        ]);

        // Cek bentrok jadwal
        $bentrok = Peminjaman::where('room_id', $request->room_id)
            ->where('tanggal', $request->tanggal)
            ->whereIn('status', ['Pending', 'Disetujui'])
            ->where(function ($q) use ($request) {
                $q->where('jam_mulai', '<', $request->jam_selesai)
                  ->where('jam_selesai', '>', $request->jam_mulai);
            })->exists();

        if ($bentrok) {
            return response()->json([
                'success' => false,
                'message' => 'Ruangan sudah dipesan pada jam tersebut.'
            ]);
        }

        try {
            $pathKtm = null;
            if ($request->hasFile('ktm')) {
                $pathKtm = $request->file('ktm')->store('ktm_mahasiswa', 'public');
            }

            Peminjaman::create([
                'user_id'     => (string) $user->_id,
                'user_name'   => $user->name,
                'room_id'     => $request->room_id,
                'room_name'   => $request->room_name,
                'tanggal'     => $request->tanggal,
                'jam_mulai'   => $request->jam_mulai,
                'jam_selesai' => $request->jam_selesai,
                'status'      => 'Pending',
                'file_ktm'    => $pathKtm,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Pengajuan peminjaman berhasil dikirim!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * GET /api/peminjaman/riwayat
     * Mengambil riwayat peminjaman untuk mahasiswa yang sedang login.
     * Mengembalikan seluruh data peminjaman milik user ini tanpa filter status.
     */
    public function riwayatPeminjaman(Request $request)
    {
        $user = $this->getUserFromToken($request);
        if (!$user) return $this->unauthorized();

        $riwayat = Peminjaman::where('user_id', (string) $user->_id)->get()->map(function($p) {
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
            'data'    => $riwayat
        ]);
    }

    // =========================================================================
    // ADMIN — RUANGAN
    // =========================================================================

    /**
     * POST /api/ruangan/simpan  (Bearer token admin)
     * Multipart: nama_ruangan, kapasitas, fasilitas, image?
     */
    public function simpanRuangan(Request $request)
    {
        $admin = $this->getAdminFromToken($request);
        if (!$admin) return $this->unauthorized();

        $request->validate([
            'nama_ruangan' => 'required',
            'kapasitas'    => 'required',
            'fasilitas'    => 'required',
        ]);

        try {
            $path = null;
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('rooms', 'public');
            }

            Room::create([
                'nama_ruangan' => $request->nama_ruangan,
                'kapasitas'    => (int) $request->kapasitas,
                'fasilitas'    => $request->fasilitas,
                'status'       => 'Tersedia',
                'image'        => $path,
            ]);

            return response()->json(['success' => true, 'message' => 'Ruangan berhasil ditambahkan!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    /**
     * PUT /api/ruangan/update/{id}  (Bearer token admin)
     * Multipart: nama_ruangan, kapasitas, fasilitas, image?
     */
    public function updateRuangan(Request $request, $id)
    {
        $admin = $this->getAdminFromToken($request);
        if (!$admin) return $this->unauthorized();

        $room = Room::where('_id', $id)->first();
        if (!$room) return response()->json(['success' => false, 'message' => 'Ruangan tidak ditemukan.']);

        try {
            $room->nama_ruangan = $request->nama_ruangan ?? $room->nama_ruangan;
            $room->kapasitas = $request->has('kapasitas') ? (int) $request->kapasitas : $room->kapasitas;
            $room->fasilitas = $request->fasilitas ?? $room->fasilitas;
            if ($request->hasFile('image')) {
                $room->image = $request->file('image')->store('rooms', 'public');
            }
            $room->save();

            return response()->json(['success' => true, 'message' => 'Ruangan berhasil diperbarui!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    /**
     * DELETE /api/ruangan/hapus/{id}  (Bearer token admin)
     */
    public function hapusRuangan($id, Request $request)
    {
        $admin = $this->getAdminFromToken($request);
        if (!$admin) return $this->unauthorized();

        $room = Room::where('_id', $id)->first();
        if ($room) {
            $room->delete();
            return response()->json(['success' => true, 'message' => 'Ruangan berhasil dihapus!']);
        }
        return response()->json(['success' => false, 'message' => 'Data tidak ditemukan.']);
    }

    // =========================================================================
    // ADMIN — PEMINJAMAN
    // =========================================================================

    /**
     * PUT /api/peminjaman/update-status/{id}  (Bearer token admin)
     * Multipart: status (Disetujui / Ditolak)
     */
    public function updateStatusPeminjaman(Request $request, $id)
    {
        $admin = $this->getAdminFromToken($request);
        if (!$admin) return $this->unauthorized();

        $peminjaman = Peminjaman::where('_id', $id)->first();
        if (!$peminjaman) {
            return response()->json(['success' => false, 'message' => 'Data peminjaman tidak ditemukan.']);
        }

        $peminjaman->status = $request->status ?? 'Pending';
        $peminjaman->save();

        return response()->json(['success' => true, 'message' => 'Status peminjaman berhasil diperbarui!']);
    }

    // =========================================================================
    // ADMIN — PENGGUNA
    // =========================================================================

    /**
     * GET /api/admin/pengguna  (Bearer token admin)
     * Mengembalikan daftar semua admin dari database.
     */
    public function getDaftarAdmin(Request $request)
    {
        $admin = $this->getAdminFromToken($request);
        if (!$admin) return $this->unauthorized();

        $admins = Admin::all()->map(function ($a) {
            return [
                'id'    => (string) $a->_id,
                'nama'  => $a->nama,
                'email' => $a->email,
                'role'  => 'admin',
            ];
        });

        return response()->json([
            'success' => true,
            'data'    => $admins,
            'total'   => $admins->count(),
        ]);
    }

    /**
     * DELETE /api/pengguna/hapus/{id}  (Bearer token admin)
     */
    public function hapusAdmin($id, Request $request)
    {
        $admin = $this->getAdminFromToken($request);
        if (!$admin) return $this->unauthorized();

        $target = Admin::where('_id', $id)->first();
        if ($target) {
            $target->delete();
            return response()->json(['success' => true, 'message' => 'Admin berhasil dihapus!']);
        }
        return response()->json(['success' => false, 'message' => 'Admin tidak ditemukan.']);
    }
}
