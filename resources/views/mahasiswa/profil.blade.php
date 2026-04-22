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
        ::-webkit-scrollbar-thumb { background: #0B0A4E; border-radius: 10px; }
    </style>
</head>
<body class="bg-[#F8FAFC]">

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

        <main class="flex-grow h-full overflow-y-auto overflow-x-hidden relative bg-[#F8FAFC]">
            
            <div class="bg-gradient-to-br from-[#0B0A4E] via-blue-700 to-cyan-500 p-12 pb-32 flex flex-col items-center text-center relative w-full">
                <div class="absolute top-0 left-0 w-full h-full opacity-10" style="background-image: radial-gradient(circle, #fff 1px, transparent 1px); background-size: 20px 20px;"></div>
                
                <div class="relative z-10">
                    <div class="w-28 h-28 rounded-[35px] border-4 border-white/20 p-1 mb-5 mx-auto shadow-2xl relative">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=0D8ABC&color=fff" class="w-full h-full rounded-[28px] object-cover shadow-inner">
                        <div class="absolute -bottom-1 -right-1 w-7 h-7 bg-emerald-500 border-4 border-[#0B0A4E] rounded-full shadow-lg"></div>
                    </div>
                    <h2 class="text-3xl font-black text-white uppercase tracking-tighter leading-tight">{{ $user->name }}</h2>
                    <p class="text-cyan-300 text-[10px] font-bold uppercase tracking-[0.3em] mt-2 bg-white/10 py-1.5 px-4 rounded-full backdrop-blur-md inline-block">Mahasiswa · IPB University</p>
                </div>
            </div>

            <div class="p-10 -mt-20 relative z-20 space-y-6 max-w-4xl mx-auto w-full">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white p-6 rounded-[35px] shadow-sm flex items-center gap-6 border border-gray-100 hover:shadow-md transition-all">
                        <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 shadow-inner flex-shrink-0">
                            <i class="fas fa-id-card text-xl"></i>
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Nomor Induk Mahasiswa</p>
                            <p class="font-bold text-[#0B0A4E] text-lg">{{ $user->nim ?? 'J0403241138' }}</p>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-[35px] shadow-sm flex items-center gap-6 border border-gray-100 hover:shadow-md transition-all">
                        <div class="w-14 h-14 bg-cyan-50 rounded-2xl flex items-center justify-center text-cyan-600 shadow-inner flex-shrink-0">
                            <i class="fas fa-envelope text-xl"></i>
                        </div>
                        <div class="min-w-0">
                            <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Email Mahasiswa</p>
                            <p class="font-bold text-[#0B0A4E] text-lg truncate">{{ $user->email }}</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-5">
                    <div class="bg-white p-7 rounded-[40px] text-center border border-gray-50 shadow-sm group hover:translate-y-[-5px] transition-all">
                        <p class="text-3xl font-black text-emerald-500 tracking-tighter mb-1">{{ $stats['disetujui'] }}</p>
                        <p class="text-[8px] font-black text-gray-400 uppercase tracking-[0.2em]">Disetujui</p>
                    </div>
                    <div class="bg-white p-7 rounded-[40px] text-center border border-gray-50 shadow-sm group hover:translate-y-[-5px] transition-all">
                        <p class="text-3xl font-black text-orange-400 tracking-tighter mb-1">{{ $stats['menunggu'] }}</p>
                        <p class="text-[8px] font-black text-gray-400 uppercase tracking-[0.2em]">Menunggu</p>
                    </div>
                    <div class="bg-white p-7 rounded-[40px] text-center border border-gray-50 shadow-sm group hover:translate-y-[-5px] transition-all">
                        <p class="text-3xl font-black text-red-500 tracking-tighter mb-1">{{ $stats['ditolak'] }}</p>
                        <p class="text-[8px] font-black text-gray-400 uppercase tracking-[0.2em]">Ditolak</p>
                    </div>
                </div>

                <div class="bg-blue-600/5 p-8 rounded-[40px] border border-blue-600/10 text-center">
                    <p class="text-[10px] font-bold text-blue-600 uppercase tracking-[0.3em]">Status Akun Aktif</p>
                </div>

            </div>
        </main>
    </div>

</body>
</html>