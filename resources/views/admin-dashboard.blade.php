<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - SIMARU</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; letter-spacing: -0.01em; }
        [x-cloak] { display: none !important; }
        .bg-navy-dark { background-color: #0B0A4E; }
        .card-shadow { box-shadow: 0 10px 40px -10px rgba(0,0,0,0.05); }
    </style>
</head>
<body class="bg-[#F8FAFC] min-h-screen">

    @php
        try {
            // Panggil model pake backslash (\) biar ga error Class Not Found
            $totalRuangan = \App\Models\Room::count();
            $totalPeminjaman = \App\Models\Peminjaman::count();
            $totalPending = \App\Models\Peminjaman::where('status', 'Menunggu')->count();
            $totalApproved = \App\Models\Peminjaman::where('status', 'Disetujui')->count();
            $totalAdmin = \App\Models\Admin::count();
            $riwayats = \App\Models\Peminjaman::latest()->take(3)->get();
        } catch (\Exception $e) {
            $totalRuangan = 0; $totalPeminjaman = 0; $totalPending = 0;
            $totalApproved = 0; $totalAdmin = 0; $riwayats = collect();
        }
    @endphp

    <div class="bg-navy-dark pt-20 pb-48 px-10 rounded-b-[60px] relative overflow-hidden text-white border-b-[8px] border-cyan-400/20">
        <div class="absolute top-0 right-0 w-1/2 h-full bg-gradient-to-l from-white/5 to-transparent"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl"></div>
        
        <div class="max-w-7xl mx-auto relative z-10">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-8">
                <div class="text-left">
                    <div class="flex items-center space-x-3 mb-6">
                        <a href="{{ route('admin.menu') }}" class="text-white/50 hover:text-white transition-colors">
                            <i class="fas fa-arrow-left text-xl"></i>
                        </a>
                        <span class="h-1 w-8 bg-cyan-400 rounded-full"></span>
                        <p class="text-cyan-400 font-bold text-[10px] uppercase tracking-[0.3em]">Administrator Dashboard</p>
                    </div>
                    <h1 class="text-5xl md:text-7xl font-black tracking-tight leading-none mb-4">
                        Dashboard <br class="md:hidden"> 
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-white to-white/40">Overview</span>
                    </h1>
                    <p class="text-blue-200 text-lg opacity-80 font-medium">
                        Selamat datang kembali, <span class="text-white font-bold">{{ Auth::user()->nama ?? 'Admin' }}</span>! 👋
                    </p>
                </div>

                <div class="bg-white/10 backdrop-blur-md p-6 rounded-[35px] border border-white/10 flex items-center space-x-4">
                    <div class="w-12 h-12 bg-cyan-400 rounded-2xl flex items-center justify-center text-[#0B0A4E] shadow-lg shadow-cyan-400/20">
                        <i class="fas fa-clock text-xl"></i>
                    </div>
                    <div>
                        <p class="text-white/50 text-[10px] font-bold uppercase tracking-widest">Waktu Sistem</p>
                        <h2 id="tanggal-realtime" class="text-sm font-black text-white leading-tight uppercase">Loading...</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-10 -mt-20 relative z-20 pb-20">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            
            <div class="lg:col-span-2 space-y-10">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="bg-white p-10 rounded-[50px] card-shadow border border-gray-50 group hover:-translate-y-2 transition-all duration-300">
                        <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-[22px] flex items-center justify-center text-2xl mb-6 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                            <i class="fas fa-door-open"></i>
                        </div>
                        <h3 class="text-5xl font-black text-[#0B0A4E] tracking-tighter">{{ $totalRuangan }}</h3>
                        <p class="text-[11px] font-black text-gray-400 uppercase tracking-widest mt-2">Total Ruangan</p>
                    </div>

                    <div class="bg-white p-10 rounded-[50px] card-shadow border border-gray-50 group hover:-translate-y-2 transition-all duration-300">
                        <div class="w-16 h-16 bg-orange-50 text-orange-500 rounded-[22px] flex items-center justify-center text-2xl mb-6 group-hover:bg-orange-500 group-hover:text-white transition-colors">
                            <i class="fas fa-hourglass-start"></i>
                        </div>
                        <h3 class="text-5xl font-black text-[#0B0A4E] tracking-tighter">{{ $totalPending }}</h3>
                        <p class="text-[11px] font-black text-gray-400 uppercase tracking-widest mt-2">Peminjaman Pending</p>
                    </div>
                </div>

                <div class="bg-white rounded-[55px] p-12 card-shadow border border-gray-50 flex flex-col md:flex-row items-center justify-between gap-12">
                    <div class="text-center md:text-left">
                        <p class="text-gray-400 text-[10px] font-black uppercase tracking-[0.2em] mb-3">Total Peminjaman</p>
                        <h3 class="text-6xl font-black text-[#0B0A4E] tracking-tighter">{{ $totalPeminjaman }}</h3>
                    </div>
                    <div class="h-20 w-px bg-gray-100 hidden md:block"></div>
                    <div class="flex-1 w-full space-y-6">
                        <div class="space-y-2">
                            <div class="flex justify-between text-[10px] font-black uppercase tracking-widest text-green-500">
                                <span>Disetujui</span>
                                <span>{{ $totalApproved }}</span>
                            </div>
                            <div class="h-3 w-full bg-gray-50 rounded-full overflow-hidden">
                                <div class="bg-green-500 h-full rounded-full" style="width: {{ $totalPeminjaman > 0 ? ($totalApproved / $totalPeminjaman) * 100 : 0 }}%"></div>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <div class="flex justify-between text-[10px] font-black uppercase tracking-widest text-blue-500">
                                <span>Total Admin</span>
                                <span>{{ $totalAdmin }}</span>
                            </div>
                            <div class="h-3 w-full bg-gray-50 rounded-full overflow-hidden">
                                <div class="bg-blue-500 h-full rounded-full w-full"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-[55px] card-shadow p-12 border border-gray-50">
                <div class="flex justify-between items-center mb-12">
                    <h3 class="text-2xl font-black text-[#0B0A4E] tracking-tight">Log Aktivitas</h3>
                    <div class="bg-blue-50 text-blue-600 p-3 rounded-2xl text-xs">
                        <i class="fas fa-history"></i>
                    </div>
                </div>

                <div class="space-y-10">
                    @forelse($riwayats as $row)
                    <div class="flex items-start space-x-5">
                        <div class="w-12 h-12 rounded-2xl flex items-center justify-center shrink-0 {{ $row->status == 'Disetujui' ? 'bg-green-50 text-green-600' : 'bg-orange-50 text-orange-500' }}">
                            <i class="fas {{ $row->status == 'Disetujui' ? 'fa-check-double' : 'fa-clock' }}"></i>
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="flex justify-between items-start mb-1">
                                <h4 class="font-bold text-[#0B0A4E] text-sm truncate pr-2 uppercase">{{ $row->peminjam }}</h4>
                                <span class="text-[8px] font-black uppercase px-2 py-1 rounded {{ $row->status == 'Disetujui' ? 'bg-green-100 text-green-600' : 'bg-orange-100 text-orange-500' }}">
                                    {{ $row->status }}
                                </span>
                            </div>
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-tighter">{{ $row->nama_ruangan }}</p>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-10 opacity-30">
                        <i class="fas fa-inbox text-4xl mb-4"></i>
                        <p class="text-xs font-black uppercase">Belum ada data</p>
                    </div>
                    @endforelse
                </div>

                <a href="{{ route('admin.peminjaman') }}" class="mt-16 block w-full py-5 text-center text-[10px] font-black text-white bg-navy-dark rounded-3xl shadow-xl hover:bg-blue-700 transition-all uppercase tracking-[0.2em]">
                    Buka Management
                </a>
            </div>

        </div>
    </div>

    <footer class="max-w-7xl mx-auto px-10 py-12 flex flex-col md:flex-row justify-between items-center border-t border-gray-100">
        <p class="text-gray-400 text-[10px] font-black uppercase tracking-[0.3em]">
            © 2026 <span class="text-navy-dark">SIMARU</span> • SEKOLAH VOKASI IPB
        </p>
        <div class="flex items-center space-x-8 mt-6 md:mt-0">
            <span class="text-[9px] font-black text-cyan-600 bg-cyan-50 px-4 py-1.5 rounded-full uppercase tracking-widest">v1.0.4 PRO</span>
            <div class="flex space-x-4">
                <i class="fab fa-instagram text-gray-300 hover:text-navy-dark transition-colors cursor-pointer"></i>
                <i class="fab fa-github text-gray-300 hover:text-navy-dark transition-colors cursor-pointer"></i>
            </div>
        </div>
    </footer>

    <script>
        function updateWaktu() {
            const skrg = new Date();
            const opt = { 
                weekday: 'short', day: 'numeric', month: 'short', year: 'numeric',
                hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false
            };
            document.getElementById('tanggal-realtime').innerText = skrg.toLocaleDateString('id-ID', opt).toUpperCase();
        }
        setInterval(updateWaktu, 1000);
        updateWaktu();
    </script>
</body>
</html>