<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMARU - Profil Mahasiswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; letter-spacing: -0.01em; }
        [x-cloak] { display: none !important; }
        html, body { max-width: 100%; overflow-x: hidden; }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #2563EB; border-radius: 10px; }
    </style>
</head>
<body class="bg-[#F0F4F8]">

    <div class="flex h-screen w-full overflow-hidden">
        
        <aside class="w-64 bg-[#0B0A4E] h-full flex flex-col p-6 shadow-2xl z-30 flex-shrink-0">
            <div class="mb-10">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-cyan-400 rounded-lg flex items-center justify-center">
                        <i class="fas fa-university text-[#0B0A4E] text-xs"></i>
                    </div>
                    <h1 class="text-xl font-black text-white tracking-tighter uppercase">SIMARU</h1>
                </div>
                <p class="text-cyan-400 text-[8px] font-black uppercase tracking-[0.3em] mt-2">Student Portal</p>
            </div>

            <nav class="flex-grow space-y-2">
                <a href="{{ route('mahasiswa.dashboard') }}" class="text-white/40 hover:text-white flex items-center gap-3 px-5 py-3.5 rounded-xl transition-all group">
                    <i class="fas fa-home text-xs"></i>
                    <span class="text-[11px] font-bold uppercase tracking-widest">Beranda</span>
                </a>
                <a href="{{ route('mahasiswa.peminjaman') }}" class="text-white/40 hover:text-white flex items-center gap-3 px-5 py-3.5 rounded-xl transition-all group">
                    <i class="fas fa-calendar-alt text-xs group-hover:text-cyan-400"></i>
                    <span class="text-[11px] font-bold uppercase tracking-widest">Peminjaman</span>
                </a>
                <a href="{{ route('mahasiswa.profil') }}" class="bg-white/10 text-white flex items-center gap-3 px-5 py-3.5 rounded-xl border-l-4 border-cyan-400">
                    <i class="fas fa-user-circle text-xs"></i>
                    <span class="text-[11px] font-bold uppercase tracking-widest">Profil</span>
                </a>
            </nav>

            <form action="{{ route('mahasiswa.logout') }}" method="POST" class="mt-auto">
                @csrf
                <button type="submit" class="w-full bg-red-500/10 hover:bg-red-500 text-red-500 hover:text-white px-5 py-3.5 rounded-xl transition-all flex items-center justify-center gap-3 border border-red-500/20">
                    <span class="text-[11px] font-black uppercase tracking-widest">Keluar</span>
                    <i class="fas fa-power-off text-xs"></i>
                </button>
            </form>
        </aside>

        <main class="flex-grow h-full overflow-y-auto overflow-x-hidden relative bg-[#F0F4F8]">
            
            <div class="bg-gradient-to-br from-[#1E3A8A] via-[#2563EB] to-[#4F46E5] p-12 pb-36 flex flex-col items-center text-center relative w-full rounded-b-[40px] shadow-lg shadow-blue-900/10">
                <div class="absolute top-0 left-0 w-full h-full opacity-10" style="background-image: radial-gradient(circle, #fff 1px, transparent 1px); background-size: 20px 20px;"></div>
                <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
                
                <div class="relative z-10 space-y-4">
                    <div class="w-24 h-24 rounded-[24px] bg-white p-1.5 mx-auto shadow-xl border border-white/20 relative group">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=EFF6FF&color=2563EB&font-size=0.4&bold=true" class="w-full h-full rounded-[18px] object-cover shadow-inner">
                        <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-emerald-500 border-4 border-white rounded-full shadow-md"></div>
                    </div>
                    <div>
                        <h2 class="text-3xl font-extrabold text-white tracking-tight leading-tight">{{ $user->name }}</h2>
                        <p class="text-blue-100 text-[10px] font-bold uppercase tracking-[0.25em] mt-1.5 bg-white/15 py-1.5 px-5 rounded-full backdrop-blur-md inline-block border border-white/5">
                            Mahasiswa · Sekolah Vokasi IPB
                        </p>
                    </div>
                </div>
            </div>

            <div class="px-10 pb-10 -mt-20 relative z-20 space-y-6 max-w-4xl mx-auto w-full">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="bg-white p-5 rounded-[24px] shadow-[0_8px_30px_rgb(0,0,0,0.015)] border border-slate-100 flex items-center gap-5 hover:shadow-md transition-all duration-300">
                        <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600 flex-shrink-0 shadow-inner">
                            <i class="fas fa-id-card text-lg"></i>
                        </div>
                        <div>
                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Nomor Induk Mahasiswa</p>
                            <p class="font-extrabold text-slate-800 text-base tracking-tight">{{ $user->nim ?? 'J0403241138' }}</p>
                        </div>
                    </div>

                    <div class="bg-white p-5 rounded-[24px] shadow-[0_8px_30px_rgb(0,0,0,0.015)] border border-slate-100 flex items-center gap-5 hover:shadow-md transition-all duration-300">
                        <div class="w-12 h-12 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600 flex-shrink-0 shadow-inner">
                            <i class="fas fa-envelope text-lg"></i>
                        </div>
                        <div class="min-w-0">
                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Email Mahasiswa</p>
                            <p class="font-extrabold text-slate-800 text-base tracking-tight truncate">{{ $user->email }}</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4">
                    <div class="bg-white p-5 rounded-[24px] text-center border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.015)] hover:-translate-y-0.5 transition-all duration-300">
                        <p class="text-3xl font-extrabold text-emerald-500 tracking-tight mb-1">{{ $stats['disetujui'] }}</p>
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Disetujui</p>
                    </div>
                    <div class="bg-white p-5 rounded-[24px] text-center border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.015)] hover:-translate-y-0.5 transition-all duration-300">
                        <p class="text-3xl font-extrabold text-orange-500 tracking-tight mb-1">{{ $stats['menunggu'] }}</p>
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Menunggu</p>
                    </div>
                    <div class="bg-white p-5 rounded-[24px] text-center border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.015)] hover:-translate-y-0.5 transition-all duration-300">
                        <p class="text-3xl font-extrabold text-rose-500 tracking-tight mb-1">{{ $stats['ditolak'] }}</p>
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Ditolak</p>
                    </div>
                </div>

                <div class="bg-blue-500/5 p-6 rounded-[24px] border border-blue-500/10 flex items-center justify-center gap-3 shadow-inner">
                    <div class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></div>
                    <p class="text-[10px] font-bold text-blue-600 uppercase tracking-widest">Status Akun: Portal Mahasiswa Aktif</p>
                </div>

            </div>
        </main>
    </div>

</body>
</html>