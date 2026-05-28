<!DOCTYPE html>
<html lang="id" x-data="{ 
    currentTab: 'Pending',
    showModalSetuju: false,
    showModalTolak: false,
    selectedId: '',
    // DATA BARU: Buat ngatur pop-up KTM mahasiswa
    showModalKtm: false,
    imgKtmUrl: ''
}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peminjaman - SIMARU Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; letter-spacing: -0.01em; }
        [x-cloak] { display: none !important; }
        .bg-navy-dark { background-color: #0B0A4E; }
        .card-shadow { box-shadow: 0 10px 40px -10px rgba(0,0,0,0.05); }
    </style>
</head>

<body class="bg-[#F8FAFC] min-h-screen pb-20">
    
    <div class="bg-navy-dark pt-20 pb-48 px-10 rounded-b-[60px] relative overflow-hidden text-white">
        <div class="absolute top-0 right-0 w-1/2 h-full bg-gradient-to-l from-white/5 to-transparent"></div>
        <div class="max-w-7xl mx-auto relative z-10 text-left">
            <div class="flex items-center space-x-3 mb-6">
                <a href="{{ route('admin.menu') }}" class="text-white/50 hover:text-white transition-colors">
                    <i class="fas fa-arrow-left text-xl"></i>
                </a>
                <span class="h-1 w-8 bg-cyan-400 rounded-full"></span>
                <p class="text-cyan-400 font-bold text-[10px] uppercase tracking-[0.3em]">Approval System</p>
            </div>
            <h1 class="text-5xl md:text-7xl font-black tracking-tight leading-none mb-4">
                Kelola <span class="text-transparent bg-clip-text bg-gradient-to-r from-white to-white/40">Peminjaman</span>
            </h1>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-10 -mt-24 relative z-20">
        @php
            $total = $peminjamans->count();
            $menunggu = $peminjamans->where('status', 'Pending')->count();
            $setuju = $peminjamans->where('status', 'Disetujui')->count();
            $tolak = $peminjamans->where('status', 'Ditolak')->count();
        @endphp

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white p-6 rounded-[35px] card-shadow border border-gray-50">
                <p class="text-gray-400 text-[9px] font-black uppercase tracking-widest mb-1">Total</p>
                <h3 class="text-3xl font-black text-navy-dark">{{ $total }}</h3>
            </div>
            <div class="bg-white p-6 rounded-[35px] card-shadow border border-gray-50 border-b-4 border-orange-400">
                <p class="text-orange-400 text-[9px] font-black uppercase tracking-widest mb-1">Pending</p>
                <h3 class="text-3xl font-black text-navy-dark">{{ $menunggu }}</h3>
            </div>
            <div class="bg-white p-6 rounded-[35px] card-shadow border border-gray-50 border-b-4 border-green-500">
                <p class="text-green-500 text-[9px] font-black uppercase tracking-widest mb-1">Disetujui</p>
                <h3 class="text-3xl font-black text-navy-dark">{{ $setuju }}</h3>
            </div>
            <div class="bg-white p-6 rounded-[35px] card-shadow border border-gray-50 border-b-4 border-red-500">
                <p class="text-red-500 text-[9px] font-black uppercase tracking-widest mb-1">Ditolak</p>
                <h3 class="text-3xl font-black text-navy-dark">{{ $tolak }}</h3>
            </div>
        </div>

        <div class="bg-white p-2 rounded-[30px] card-shadow flex mb-10 border border-gray-100 max-w-2xl mx-auto">
            <template x-for="tab in ['Pending', 'Disetujui', 'Ditolak']">
                <button @click="currentTab = tab" 
                        :class="currentTab === tab ? 'bg-navy-dark text-white shadow-xl' : 'text-gray-400 hover:text-navy-dark'"
                        class="flex-1 py-4 rounded-[22px] text-[10px] font-black uppercase tracking-widest transition-all duration-300"
                        x-text="tab === 'Pending' ? 'Menunggu' : tab"></button>
            </template>
        </div>

        <div class="bg-white rounded-[45px] card-shadow border border-gray-50 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-50/50 text-gray-400 text-[10px] uppercase tracking-[0.2em] font-black border-b border-gray-100">
                            <th class="px-12 py-8">Ruang & Mahasiswa</th>
                            <th class="px-12 py-8">Waktu Pinjam</th>
                            <th class="px-12 py-8 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($peminjamans as $item)
                        <tr x-show="currentTab === '{{ $item->status }}'" x-transition class="hover:bg-gray-50/30 transition-colors">
                            <td class="px-12 py-9">
                                <div class="flex items-center space-x-5">
                                    <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-lg shadow-inner">
                                        <i class="fas fa-university"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-extrabold text-[#0B0A4E] text-base uppercase tracking-tight">
                                            {{ $item->room_name ?? 'Tanpa Nama Ruang' }}
                                        </h4>
                                        <div class="flex flex-col sm:flex-row sm:items-center gap-2 mt-1">
                                            <p class="text-[11px] text-blue-500 font-bold uppercase tracking-widest">
                                                {{ $item->user_name ?? 'Mahasiswa Anonim' }}
                                            </p>
                                            
                                            @if(!empty($item->file_ktm))
                                                <button @click="imgKtmUrl = '{{ asset('storage/' . $item->file_ktm) }}'; showModalKtm = true" class="inline-flex items-center gap-1.5 bg-cyan-50 hover:bg-cyan-100 text-cyan-600 font-black px-2.5 py-0.5 rounded-lg text-[9px] uppercase tracking-wider transition-all border border-cyan-200 w-max cursor-pointer">
                                                    <i class="fas fa-id-card"></i> Lihat KTM
                                                </button>
                                            @else
                                                <span class="text-[8px] text-slate-400 font-bold uppercase tracking-wider italic">Gak Ada Berkas</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-12 py-9">
                                <div class="text-[#0B0A4E] font-black text-sm uppercase">{{ $item->tanggal }}</div>
                                <div class="text-gray-400 text-[11px] font-bold mt-1 uppercase">
                                    <i class="far fa-clock mr-1 text-cyan-500"></i> {{ $item->jam_mulai }} - {{ $item->jam_selesai }}
                                </div>
                            </td>
                            <td class="px-12 py-9">
                                <div class="flex justify-center">
                                    @if($item->status == 'Pending')
                                    <div class="flex space-x-3">
                                        <button @click="selectedId = '{{ (string)$item->_id }}'; showModalSetuju = true" 
                                                class="bg-emerald-500 hover:bg-emerald-600 text-white px-6 py-3 rounded-xl text-[9px] font-black uppercase shadow-lg shadow-emerald-100 transition-all active:scale-95">Setujui</button>
                                        <button @click="selectedId = '{{ (string)$item->_id }}'; showModalTolak = true" 
                                                class="bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-xl text-[9px] font-black uppercase shadow-lg shadow-red-100 transition-all active:scale-95">Tolak</button>
                                    </div>
                                    @else
                                    <span class="px-5 py-2 rounded-xl text-[9px] font-black uppercase border 
                                        {{ $item->status == 'Disetujui' ? 'bg-green-50 text-green-600 border-green-100' : 'bg-red-50 text-red-600 border-red-100' }}">
                                        {{ $item->status }}
                                    </span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-12 py-24 text-center">
                                <i class="fas fa-inbox text-5xl text-gray-100 mb-4"></i>
                                <p class="text-gray-300 font-black uppercase tracking-widest text-xs">Data Peminjaman Kosong!</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div x-show="showModalSetuju || showModalTolak" class="fixed inset-0 z-[100] flex items-center justify-center bg-navy-dark/60 backdrop-blur-md px-10" x-cloak x-transition>
        <div class="bg-white rounded-[45px] p-10 max-w-sm w-full shadow-2xl text-center border-t-[10px]" 
             :class="showModalSetuju ? 'border-green-500' : 'border-red-500'"
             @click.outside="showModalSetuju = false; showModalTolak = false">
            <h3 class="text-2xl font-black text-navy-dark mb-8" x-text="showModalSetuju ? 'Setujui Pengajuan?' : 'Tolak Pengajuan?'"></h3>
            <div class="flex space-x-3">
                <button @click="showModalSetuju = false; showModalTolak = false" class="flex-1 bg-gray-100 py-4 rounded-2xl font-black text-[10px] uppercase">Batal</button>
                <button @click="updateStatus(showModalSetuju ? 'Disetujui' : 'Ditolak')" 
                        :class="showModalSetuju ? 'bg-green-500' : 'bg-red-500'" 
                        class="flex-1 text-white py-4 rounded-2xl font-black text-[10px] uppercase shadow-xl">Konfirmasi</button>
            </div>
        </div>
    </div>

    <div x-show="showModalKtm" x-cloak class="fixed inset-0 z-[110] flex items-center justify-center bg-navy-dark/80 backdrop-blur-md p-4" x-transition.opacity>
        <div x-show="showModalKtm" x-transition.scale.95 class="bg-white rounded-[35px] overflow-hidden max-w-xl w-full shadow-2xl relative border border-slate-100 flex flex-col" @click.outside="showModalKtm = false">
            
            <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <div class="flex items-center gap-2 text-navy-dark">
                    <i class="fas fa-id-card text-sm"></i>
                    <h3 class="text-xs font-black uppercase tracking-wider">Berkas KTM Mahasiswa</h3>
                </div>
                <button @click="showModalKtm = false" class="text-slate-400 hover:text-red-500 transition-colors">
                    <i class="fas fa-times-circle text-xl"></i>
                </button>
            </div>

            <div class="p-6 bg-slate-100/50 flex items-center justify-center max-h-[70vh] overflow-y-auto">
                <img :src="imgKtmUrl" alt="KTM Mahasiswa" class="w-full h-auto object-contain rounded-2xl shadow-sm border border-slate-200">
            </div>

            <div class="px-6 py-4 border-t border-slate-100 flex justify-end bg-slate-50/50">
                <button @click="showModalKtm = false" class="bg-navy-dark hover:bg-opacity-90 text-white font-bold px-6 py-2.5 rounded-xl text-[10px] uppercase tracking-wider shadow-md transition-all active:scale-95">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <script>
        function updateStatus(statusBaru) {
            const id = Alpine.$data(document.querySelector('[x-data]')).selectedId;
            fetch(`/peminjaman/admin/update-status/${id}`, {
                method: "POST",
                headers: { 
                    'X-CSRF-TOKEN': "{{ csrf_token() }}", 
                    'Content-Type': 'application/json', 
                    'Accept': 'application/json' 
                },
                body: JSON.stringify({ _method: 'PUT', status: statusBaru })
            })
            .then(res => res.json())
            .then(data => { 
                if(data.success) {
                    window.location.reload();
                } else {
                    alert("Gagal update: " + data.message);
                }
            });
        }
    </script>
</body>
</html>