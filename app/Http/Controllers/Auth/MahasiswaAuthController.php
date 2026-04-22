<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class MahasiswaAuthController extends Controller
{
    public function showLoginForm() { return view('auth.mahasiswa-login'); }
    public function showRegisterForm() { return view('auth.mahasiswa-register'); }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'mahasiswa',
            'nim' => $request->nim ?? '-',
        ]);

        return redirect()->route('mahasiswa.login')->with('success', 'Akun berhasil dibuat. Silakan masuk menggunakan kredensial Anda.');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            if (Auth::user()->role === 'mahasiswa') {
                return redirect()->intended('/dashboard/mahasiswa');
            }

            Auth::logout();
            return back()->withErrors(['email' => 'Akses ditolak. Ini adalah portal khusus mahasiswa.']);
        }

        return back()->withErrors(['email' => 'Email atau kata sandi yang Anda masukkan salah.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function index()
{
        $rooms = \App\Models\Room::all(); 

    // Kirim variabel $rooms ke halaman dashboard
    return view('mahasiswa.dashboard', compact('rooms'));
}

}