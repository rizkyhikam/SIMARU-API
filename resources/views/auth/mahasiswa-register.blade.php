<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Mahasiswa - SIMARU</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; margin: 0; padding: 0; }
    </style>
</head>
<body class="h-screen w-full overflow-hidden">

    <div class="flex h-full w-full">
        
        <div class="w-[40%] bg-[#0B0A4E] flex flex-col justify-between p-16 relative">
            <a href="{{ route('mahasiswa.login') }}" class="w-12 h-12 bg-white/10 hover:bg-white/20 rounded-2xl flex items-center justify-center text-white transition-all">
                <i class="fas fa-chevron-left"></i>
            </a>

            <div class="text-center">
                <div class="w-20 h-20 bg-white/5 rounded-3xl flex items-center justify-center mb-8 mx-auto border border-white/10">
                    <i class="fas fa-user-plus text-3xl text-cyan-400"></i>
                </div>
                <h1 class="text-5xl font-black text-white tracking-tighter uppercase">SIMARU</h1>
                <p class="text-cyan-400 text-[10px] font-black uppercase tracking-[0.4em] mt-2">Student Portal Access</p>
                <div class="w-16 h-1 bg-cyan-400 rounded-full mt-8 mx-auto opacity-40"></div>
            </div>

            <div class="text-center opacity-30">
                <p class="text-[9px] text-white font-medium uppercase tracking-[0.2em]">
                    © 2026 SEKOLAH VOKASI IPB UNIVERSITY<br>
                    SISTEM INFORMASI PEMINJAMAN RUANGAN
                </p>
            </div>
        </div>

        <div class="w-[60%] bg-white flex flex-col justify-center px-24">
            
            <div class="max-w-2xl">
                @if($errors->any())
                    <div class="bg-red-50 border border-red-100 text-red-600 px-6 py-4 rounded-2xl mb-8 text-[11px] font-bold tracking-widest uppercase shadow-sm">
                        <i class="fas fa-exclamation-circle mr-2"></i> {{ $errors->first() }}
                    </div>
                @endif

                <div class="mb-10">
                    <h2 class="text-5xl font-black text-[#0B0A4E] tracking-tighter uppercase mb-2">Daftar Akun</h2>
                    <p class="text-gray-400 text-xs font-black uppercase tracking-[0.3em]">Silakan isi data diri anda dengan benar</p>
                </div>

                <form action="{{ route('mahasiswa.register') }}" method="POST" class="grid grid-cols-2 gap-x-8 gap-y-6">
                    @csrf
                    
                    <div class="col-span-1">
                        <label class="text-[10px] font-black text-[#0B0A4E] uppercase ml-6 mb-2 block tracking-widest opacity-40">Nama Lengkap</label>
                        <div class="relative">
                            <i class="fas fa-id-card absolute left-6 top-1/2 -translate-y-1/2 text-cyan-500 text-sm"></i>
                            <input type="text" name="name" value="{{ old('name') }}" required class="w-full bg-[#F3F6FF] border-none px-14 py-5 rounded-2xl focus:ring-2 focus:ring-[#0B0A4E]/5 transition-all text-sm font-semibold" placeholder="Masukkan nama...">
                        </div>
                    </div>

                    <div class="col-span-1">
                        <label class="text-[10px] font-black text-[#0B0A4E] uppercase ml-6 mb-2 block tracking-widest opacity-40">NIM Mahasiswa</label>
                        <div class="relative">
                            <i class="fas fa-graduation-cap absolute left-6 top-1/2 -translate-y-1/2 text-cyan-500 text-sm"></i>
                            <input type="text" name="nim" value="{{ old('nim') }}" required class="w-full bg-[#F3F6FF] border-none px-14 py-5 rounded-2xl focus:ring-2 focus:ring-[#0B0A4E]/5 transition-all text-sm font-semibold" placeholder="Masukkan NIM...">
                        </div>
                    </div>

                    <div class="col-span-2">
                        <label class="text-[10px] font-black text-[#0B0A4E] uppercase ml-6 mb-2 block tracking-widest opacity-40">Email Mahasiswa</label>
                        <div class="relative">
                            <i class="fas fa-envelope absolute left-6 top-1/2 -translate-y-1/2 text-cyan-500 text-sm"></i>
                            <input type="email" name="email" value="{{ old('email') }}" required class="w-full bg-[#F3F6FF] border-none px-14 py-5 rounded-2xl focus:ring-2 focus:ring-[#0B0A4E]/5 transition-all text-sm font-semibold" placeholder="Masukkan email...">
                        </div>
                    </div>

                    <div class="col-span-1">
                        <label class="text-[10px] font-black text-[#0B0A4E] uppercase ml-6 mb-2 block tracking-widest opacity-40">Password</label>
                        <div class="relative">
                            <i class="fas fa-lock absolute left-6 top-1/2 -translate-y-1/2 text-cyan-500 text-sm"></i>
                            <input type="password" name="password" required class="w-full bg-[#F3F6FF] border-none px-14 py-5 rounded-2xl focus:ring-2 focus:ring-[#0B0A4E]/5 transition-all text-sm font-semibold" placeholder="Min. 8 Karakter...">
                        </div>
                    </div>

                    <div class="col-span-1">
                        <label class="text-[10px] font-black text-[#0B0A4E] uppercase ml-6 mb-2 block tracking-widest opacity-40">Konfirmasi Password</label>
                        <div class="relative">
                            <i class="fas fa-shield-alt absolute left-6 top-1/2 -translate-y-1/2 text-cyan-500 text-sm"></i>
                            <input type="password" name="password_confirmation" required class="w-full bg-[#F3F6FF] border-none px-14 py-5 rounded-2xl focus:ring-2 focus:ring-[#0B0A4E]/5 transition-all text-sm font-semibold" placeholder="Ulangi...">
                        </div>
                    </div>

                    <div class="col-span-2 pt-4">
                        <button type="submit" class="w-full bg-[#0B0A4E] hover:bg-cyan-400 text-white hover:text-[#0B0A4E] font-black py-5 rounded-2xl transition-all shadow-xl shadow-indigo-900/10 uppercase text-xs tracking-[0.3em] flex items-center justify-center gap-3">
                            <span>Daftar Sekarang</span>
                            <i class="fas fa-arrow-right text-[10px]"></i>
                        </button>
                        
                        <p class="text-center mt-8 text-[11px] font-bold text-gray-400">
                            Already have an account? 
                            <a href="{{ route('mahasiswa.login') }}" class="text-[#0B0A4E] font-black hover:text-cyan-600 transition-colors ml-1">Login Here</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>
</html>