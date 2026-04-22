<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMARU - Riwayat Peminjaman</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; letter-spacing: -0.01em; }
        [x-cloak] { display: none !important; }
        html, body { max-width: 100%; overflow-x: hidden; }
    </style>
</head>
<body class="bg-[#F8FAFC]" x-data="{ tab: 'Semua' }">

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
                <a href="{{ route('mahasiswa.peminjaman') }}" class="bg-white/10 text-white flex items-center gap-3 px-5 py-3.5 rounded-xl border-l-4 border-cyan-400">
                    <i class="fas fa-calendar-alt text-xs"></i>
                    <span class="text-[11px] font-bold uppercase tracking-widest">Peminjaman</span>
                </a>
                <a href="{{ route('mahasiswa.profil') }}" class="text-white/40 hover:text-white flex items-center gap-3 px-5 py-3.5 rounded-xl transition-all group">
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
            
            <div class="bg-gradient-to-br from-[#0B0A4E] via-blue-700 to-cyan-500 p-10 pb-24 relative w-full">
                <div class="absolute top-0 right-0 w-1/3 h-full bg-white/5 skew-x-[-20deg] translate-x-20"></div>
                
                <h2 class="text-3xl font-black text-white uppercase tracking-tighter mb-8 relative z-10">Riwayat Peminjaman</h2>
                
                <div class="flex bg-white/10 p-1.5 rounded-2xl backdrop-blur-md relative z-10 w-full max-w-xl overflow-hidden">
                    <button @click="tab = 'Semua'" :class="tab == 'Semua' ? 'bg-white text-[#0B0A4E] shadow-lg' : 'text-white/60'" class="flex-1 py-3 rounded-xl text-[10px] font-black uppercase transition-all">Semua</button>
                    <button @click="tab = 'Pending'" :class="tab == 'Pending' ? 'bg-white text-[#0B0A4E] shadow-lg' : 'text-white/60'" class="flex-1 py-3 rounded-xl text-[10px] font-black uppercase transition-all">Menunggu</button>
                    <button @click="tab = 'Disetujui'" :class="tab == 'Disetujui' ? 'bg-white text-[#0B0A4E] shadow-lg' : 'text-white/60'" class="flex-1 py-3 rounded-xl text-[10px] font-black uppercase transition-all">Disetujui</button>
                    <button @click="tab = 'Ditolak'" :class="tab == 'Ditolak' ? 'bg-white text-[#0B0A4E] shadow-lg' : 'text-white/60'" class="flex-1 py-3 rounded-xl text-[10px] font-black uppercase transition-all">Ditolak</button>
                </div>
            </div>

            <div class="p-10 -mt-10 relative z-20 space-y-5 w-full">
                @forelse($peminjamans as $pinjam)
                <div x-show="tab == 'Semua' || tab == '{{ $pinjam->status }}'" 
                     x-cloak
                     class="bg-white p-6 rounded-[35px] shadow-sm border border-gray-100 flex flex-col md:flex-row items-center justify-between gap-6 hover:shadow-md transition-all w-full">
                    
                    <div class="flex items-center gap-5 w-full">
                        <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 flex-shrink-0">
                            <i class="fas fa-map-marker-alt text-xl"></i>
                        </div>
                        <div class="flex-grow min-w-0">
                            <div class="flex flex-wrap items-center gap-3 mb-2">
                                <h4 class="font-black text-[#0B0A4E] text-lg uppercase truncate">{{ $pinjam->room_name }}</h4>
                                <span class="text-[9px] font-black px-4 py-1.5 rounded-full uppercase
                                    {{ $pinjam->status == 'Pending' ? 'bg-orange-50 text-orange-500' : '' }}
                                    {{ $pinjam->status == 'Disetujui' ? 'bg-emerald-50 text-emerald-600' : '' }}
                                    {{ $pinjam->status == 'Ditolak' ? 'bg-red-50 text-red-600' : '' }}">
                                    ● {{ $pinjam->status == 'Pending' ? 'Menunggu' : $pinjam->status }}
                                </span>
                            </div>
                            <div class="flex flex-wrap gap-x-6 gap-y-2 text-[10px] font-bold text-gray-400">
                                <span class="flex items-center"><i class="far fa-calendar-alt mr-2 text-blue-400"></i> {{ $pinjam->tanggal }}</span>
                                <span class="flex items-center"><i class="far fa-clock mr-2 text-blue-400"></i> {{ $pinjam->jam_mulai }} - {{ $pinjam->jam_selesai }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="flex flex-col items-center justify-center py-20 bg-white rounded-[40px] border-2 border-dashed border-gray-100 w-full">
                    <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mb-6 shadow-inner">
                        <i class="fas fa-clipboard-list text-4xl text-slate-300"></i>
                    </div>
                    
                    <h3 class="text-lg font-extrabold text-[#0B0A4E] uppercase tracking-tight mb-2">Tidak Ada Data Peminjaman</h3>
                    <p class="text-slate-400 text-xs font-medium max-w-sm text-center leading-relaxed px-6">
                        Sistem tidak menemukan riwayat pengajuan peminjaman pada akun Anda. Pastikan Anda telah melakukan prosedur pemesanan ruangan melalui menu Beranda.
                    </p>

                    <a href="{{ route('mahasiswa.dashboard') }}" class="mt-8 bg-[#0B0A4E] hover:bg-blue-800 text-white px-10 py-3.5 rounded-2xl text-[10px] font-bold uppercase tracking-widest transition-all shadow-xl shadow-blue-900/10 active:scale-95">
                        Kembali ke Dashboard
                    </a>
                </div>
                @endforelse
            </div>
        </main>
    </div>

</body>
</html>