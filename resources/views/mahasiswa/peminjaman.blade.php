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
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #2563EB; border-radius: 10px; }
    </style>
</head>
<body class="bg-[#F0F4F8]" x-data="{ tab: 'Semua' }">

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

        <main class="flex-grow h-full overflow-y-auto overflow-x-hidden relative bg-[#F0F4F8]">
            
            <div class="bg-gradient-to-br from-[#1E3A8A] via-[#2563EB] to-[#4F46E5] p-10 pb-36 relative w-full rounded-b-[40px] shadow-lg shadow-blue-900/10">
                <div class="absolute top-0 right-0 w-1/3 h-full bg-white/5 skew-x-[-20deg] translate-x-20"></div>
                <div class="absolute -left-10 -bottom-10 w-40 h-40 bg-white/10 rounded-full blur-3xl"></div>
                
                <h2 class="text-3xl font-extrabold text-white tracking-tight mb-8 relative z-10">Riwayat Peminjaman</h2>
                
                <div class="flex bg-blue-950/40 p-1.5 rounded-2xl backdrop-blur-md relative z-10 w-full max-w-xl border border-white/5 overflow-hidden">
                    <button @click="tab = 'Semua'" :class="tab == 'Semua' ? 'bg-white text-blue-900 shadow-md shadow-blue-950/10' : 'text-blue-100 hover:text-white'" class="flex-1 py-3 rounded-xl text-[10px] font-black uppercase tracking-wider transition-all">Semua</button>
                    <button @click="tab = 'Pending'" :class="tab == 'Pending' ? 'bg-white text-blue-900 shadow-md shadow-blue-950/10' : 'text-blue-100 hover:text-white'" class="flex-1 py-3 rounded-xl text-[10px] font-black uppercase tracking-wider transition-all">Menunggu</button>
                    <button @click="tab = 'Disetujui'" :class="tab == 'Disetujui' ? 'bg-white text-blue-900 shadow-md shadow-blue-950/10' : 'text-blue-100 hover:text-white'" class="flex-1 py-3 rounded-xl text-[10px] font-black uppercase tracking-wider transition-all">Disetujui</button>
                    <button @click="tab = 'Ditolak'" :class="tab == 'Ditolak' ? 'bg-white text-blue-900 shadow-md shadow-blue-950/10' : 'text-blue-100 hover:text-white'" class="flex-1 py-3 rounded-xl text-[10px] font-black uppercase tracking-wider transition-all">Ditolak</button>
                </div>
            </div>

            <div class="px-10 pb-10 -mt-20 relative z-20 space-y-4 w-full">
                @forelse($peminjamans as $pinjam)
                <div x-show="tab == 'Semua' || tab == '{{ $pinjam->status }}'" 
                     x-cloak
                     class="bg-white p-5 rounded-[28px] shadow-[0_8px_30px_rgb(0,0,0,0.015)] border border-slate-100 flex flex-col md:flex-row items-center justify-between gap-6 hover:shadow-[0_15px_35px_rgba(0,0,0,0.025)] hover:-translate-y-0.5 transition-all duration-300 w-full group">
                    
                    <div class="flex items-center gap-5 w-full">
                        <div class="w-14 h-14 bg-blue-50 rounded-[20px] flex items-center justify-center text-blue-600 flex-shrink-0 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                            <i class="fas fa-map-marker-alt text-xl"></i>
                        </div>
                        <div class="flex-grow min-w-0">
                            <div class="flex flex-wrap items-center gap-3 mb-2.5">
                                <h4 class="font-extrabold text-slate-900 text-lg tracking-tight group-hover:text-blue-600 transition-colors">{{ $pinjam->room_name }}</h4>
                                
                                <span class="text-[10px] font-bold px-4 py-1 rounded-xl uppercase border
                                    {{ $pinjam->status == 'Pending' ? 'bg-orange-50 text-orange-500 border-orange-200/50' : '' }}
                                    {{ $pinjam->status == 'Disetujui' ? 'bg-emerald-50 text-emerald-600 border-emerald-200/50' : '' }}
                                    {{ $pinjam->status == 'Ditolak' ? 'bg-rose-50 text-rose-600 border-rose-200/50' : '' }}">
                                    ● {{ $pinjam->status == 'Pending' ? 'Menunggu' : $pinjam->status }}
                                </span>
                            </div>
                            <div class="flex flex-wrap gap-x-6 gap-y-2 text-xs font-semibold text-slate-400">
                                <span class="flex items-center"><i class="far fa-calendar-alt mr-2 text-blue-500/80"></i> {{ $pinjam->tanggal }}</span>
                                <span class="flex items-center"><i class="far fa-clock mr-2 text-blue-500/80"></i> {{ $pinjam->jam_mulai }} - {{ $pinjam->jam_selesai }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="flex flex-col items-center justify-center py-20 bg-white rounded-[32px] border border-dashed border-slate-200 w-full">
                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mb-5 shadow-inner">
                        <i class="fas fa-clipboard-list text-3xl text-slate-300"></i>
                    </div>
                    
                    <h3 class="text-base font-extrabold text-slate-900 uppercase tracking-wider mb-2">Tidak Ada Data Peminjaman</h3>
                    <p class="text-slate-400 text-xs font-medium max-w-sm text-center leading-relaxed px-6 mb-6">
                        Sistem tidak menemukan riwayat pengajuan peminjaman pada kategori ini. Silakan lakukan pemesanan fasilitas melalui menu Beranda.
                    </p>

                    <a href="{{ route('mahasiswa.dashboard') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3.5 rounded-xl text-xs font-bold tracking-wide transition-all shadow-md shadow-blue-600/10 active:scale-95">
                        Kembali ke Beranda
                    </a>
                </div>
                @endforelse
            </div>
        </main>
    </div>

</body>
</html>