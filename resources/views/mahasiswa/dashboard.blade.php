<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMARU - Dashboard Mahasiswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; letter-spacing: -0.01em; }
        [x-cloak] { display: none !important; }
        html, body { max-width: 100%; overflow-x: hidden; }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #2563EB; border-radius: 10px; }
        .glass-card { background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(16px); border: 1px solid rgba(255, 255, 255, 0.6); }
    </style>
</head>
<body class="bg-[#F0F4F8]" x-data="{ openModal: false, openSchedule: '{{ request('filter_date') ? true : false }}', selectedRoom: {} }">

    <div class="flex h-screen w-full overflow-hidden">
        <aside class="w-64 bg-[#0B0A4E] h-full flex flex-col p-6 shadow-2xl z-30 flex-shrink-0">
            <div class="mb-10 flex flex-col items-start">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white rounded-xl overflow-hidden shadow-md flex items-center justify-center p-0.5 flex-shrink-0">
                        <img src="{{ asset('storage/rooms/logo simaru.jpeg') }}" alt="Logo SIMARU" class="w-full h-full object-cover rounded-lg">
                    </div>
                    <h1 class="text-xl font-black text-white tracking-tighter uppercase">SIMARU</h1>
                </div>
                <p class="text-cyan-400 text-[8px] font-black uppercase tracking-[0.3em] mt-2 pl-1">Student Portal</p>
            </div>

            <nav class="flex-grow space-y-2">
                <a href="{{ route('mahasiswa.dashboard') }}" class="bg-white/10 text-white flex items-center gap-3 px-5 py-3.5 rounded-xl border-l-4 border-cyan-400 transition-all">
                    <i class="fas fa-home text-xs"></i>
                    <span class="text-[11px] font-bold uppercase tracking-widest">Beranda</span>
                </a>
                <a href="{{ route('mahasiswa.peminjaman') }}" class="text-white/40 hover:text-white flex items-center gap-3 px-5 py-3.5 rounded-xl transition-all group">
                    <i class="fas fa-calendar-alt text-xs group-hover:text-cyan-400"></i>
                    <span class="text-[11px] font-bold uppercase tracking-widest">Peminjaman</span>
                </a>
                <a href="{{ route('mahasiswa.profil') }}" class="text-white/40 hover:text-white flex items-center gap-3 px-5 py-3.5 rounded-xl transition-all group">
                    <i class="fas fa-user-circle text-xs group-hover:text-cyan-400"></i>
                    <span class="text-[11px] font-bold uppercase tracking-widest">Profil</span>
                </a>
            </nav>

            <form action="{{ route('mahasiswa.logout') }}" method="POST" class="mt-auto">
                @csrf
                <button type="submit" class="w-full bg-red-500/10 hover:bg-red-500 text-red-500 hover:text-white px-5 py-3.5 rounded-xl transition-all flex items-center justify-center gap-3 border border-red-500/20 group">
                    <span class="text-[11px] font-black uppercase tracking-widest">Keluar</span>
                    <i class="fas fa-power-off text-xs group-hover:rotate-90 transition-transform"></i>
                </button>
            </form>
        </aside>

        <main class="flex-grow h-full overflow-y-auto overflow-x-hidden relative bg-[#F0F4F8]">
            <div class="bg-gradient-to-br from-[#1E3A8A] via-[#2563EB] to-[#4F46E5] p-10 pb-32 relative w-full rounded-b-[40px] shadow-lg shadow-blue-900/10">
                <div class="absolute top-0 right-0 w-1/3 h-full bg-white/5 skew-x-[-20deg] translate-x-20"></div>
                <div class="absolute -left-10 -bottom-10 w-40 h-40 bg-white/10 rounded-full blur-3xl"></div>
                
                <div class="text-white relative z-10 space-y-1">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="w-6 h-[2px] bg-cyan-400 rounded-full"></span>
                        <p class="text-[9px] font-bold uppercase tracking-[0.25em] text-cyan-300">Student Portal Dashboard</p>
                    </div>
                    <h2 class="text-3xl font-extrabold tracking-tight">Halo, {{ Auth::user()->name }}! 👋</h2>
                    <p class="text-xs text-blue-100 opacity-80 font-medium">Mau pinjam ruangan apa untuk aktivitas akademikmu hari ini?</p>
                </div>

                <div class="grid grid-cols-2 gap-6 absolute -bottom-16 left-10 right-10 z-20">
                    <div class="glass-card p-6 rounded-[28px] shadow-[0_15px_40px_rgba(37,99,235,0.04)] flex items-center justify-between group hover:-translate-y-1 transition-all duration-300">
                        <div class="flex items-center gap-5">
                            <div class="w-12 h-12 bg-blue-600 rounded-2xl flex items-center justify-center shadow-md shadow-blue-600/20">
                                <i class="fas fa-door-open text-lg text-white"></i>
                            </div>
                            <div class="min-w-0">
                                <p class="text-[9px] font-bold uppercase tracking-wider text-slate-400 mb-0.5">Total Ruangan</p>
                                <h3 class="text-3xl font-extrabold text-slate-900 tracking-tight">{{ $rooms->count() }}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="glass-card p-6 rounded-[28px] shadow-[0_15px_40px_rgba(37,99,235,0.04)] flex items-center justify-between group hover:-translate-y-1 transition-all duration-300">
                        <div class="flex items-center gap-5">
                            <div class="w-12 h-12 bg-emerald-500 rounded-2xl flex items-center justify-center shadow-md shadow-emerald-500/20">
                                <i class="fas fa-check-circle text-lg text-white"></i>
                            </div>
                            <div class="min-w-0">
                                <p class="text-[9px] font-bold uppercase tracking-wider text-slate-400 mb-0.5">Ruang Tersedia</p>
                                <h3 class="text-3xl font-extrabold text-emerald-600 tracking-tight">{{ $rooms->where('status', 'Tersedia')->count() }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-10 mt-20 w-full">
                <div class="mb-6 flex justify-end">
                    <button @click="openSchedule = true" class="bg-cyan-500 hover:bg-cyan-600 text-[#0B0A4E] font-black px-6 py-4 rounded-2xl text-[10px] uppercase tracking-widest shadow-lg transition-all flex items-center gap-3 active:scale-95">
                        <i class="fas fa-clock text-lg"></i> Cek Ketersediaan Hari Ini
                    </button>
                </div>

                <div class="grid grid-cols-1 gap-5 w-full">
                    @forelse($rooms as $room)
                    <div class="bg-white p-4 rounded-[28px] shadow-[0_8px_30px_rgb(0,0,0,0.015)] border border-slate-100 flex flex-col md:flex-row items-center gap-6 hover:shadow-[0_20px_40px_rgba(0,0,0,0.03)] hover:-translate-y-0.5 transition-all duration-300 w-full group">
                        
                        <div class="w-full md:w-52 h-36 overflow-hidden rounded-[20px] bg-slate-50 flex-shrink-0 relative shadow-inner">
                            <img src="{{ $room->image ? asset('storage/' . $room->image) : 'https://via.placeholder.com/400x280?text=No+Image' }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        </div>
                        
                        <div class="flex-grow text-center md:text-left min-w-0 py-2">
                            <span class="text-[9px] font-bold text-blue-600 uppercase tracking-widest block mb-1">Fasilitas Kampus</span>
                            <h4 class="text-xl font-extrabold text-slate-900 tracking-tight mb-3 truncate group-hover:text-blue-600 transition-colors">{{ $room->nama_ruangan }}</h4>
                            
                            <div class="flex flex-wrap justify-center md:justify-start items-center gap-2">
                                <span class="{{ $room->status == 'Tersedia' ? 'bg-emerald-50 text-emerald-600 border-emerald-200/60' : 'bg-rose-50 text-rose-600 border-rose-200/60' }} text-[10px] font-bold px-4 py-1.5 rounded-xl uppercase border">
                                    {{ $room->status }}
                                </span>
                                <span class="bg-blue-50/60 text-blue-600 border border-blue-100/50 text-[10px] font-bold px-4 py-1.5 rounded-xl uppercase">
                                    <i class="fas fa-users mr-1.5 opacity-80"></i> {{ $room->kapasitas }} Kursi
                                </span>
                            </div>
                        </div>
                        
                        <div class="w-full md:w-auto px-4">
                            <button @click="openModal = true; selectedRoom = {{ json_encode($room) }}" class="w-full md:w-auto bg-blue-600 hover:bg-blue-700 text-white font-bold px-8 py-3.5 rounded-xl text-xs tracking-wide shadow-md shadow-blue-600/10 hover:shadow-blue-600/20 transition-all active:scale-95">
                                Booking Ruangan
                            </button>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-16 bg-white rounded-[32px] border border-dashed border-slate-200 text-slate-400 font-bold uppercase text-xs w-full tracking-wider">Belum ada data ruangan yang tersedia.</div>
                    @endforelse
                </div>
            </div>
        </main>
    </div>

    <div x-show="openModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div x-show="openModal" x-transition.opacity class="fixed inset-0 bg-[#0B0A4E]/60 backdrop-blur-md" @click="openModal = false"></div>
        <div x-show="openModal" x-transition.scale.95 class="bg-white w-full max-w-md rounded-2xl overflow-hidden shadow-2xl relative z-10 border border-slate-100 max-h-[90vh] flex flex-col">
            
            <div class="h-44 relative flex-shrink-0">
                <img :src="selectedRoom.image ? '/storage/' + selectedRoom.image : 'https://via.placeholder.com/400x280'" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                <div class="absolute bottom-4 left-6 text-white">
                    <h3 class="text-xl font-extrabold uppercase tracking-tight" x-text="selectedRoom.nama_ruangan"></h3>
                </div>
                <button @click="openModal = false" class="absolute top-4 right-4 text-white/60 hover:text-white transition-colors">
                    <i class="fas fa-times-circle text-xl"></i>
                </button>
            </div>

            <div class="p-6 overflow-y-auto space-y-4 text-left flex-grow" x-data="{ ktmFile: '' }">
                <form id="formAjukanBooking" class="space-y-4" enctype="multipart/form-data">
                    @csrf
                    <div class="bg-slate-50 p-5 rounded-2xl border border-slate-100 space-y-3">
                        <div>
                            <label class="text-[9px] font-black text-slate-400 uppercase ml-1 mb-1 block">Tanggal Pinjam</label>
                            <input type="date" name="tanggal" required class="w-full bg-white border border-slate-200/60 py-2.5 px-4 rounded-xl text-xs font-bold outline-none focus:border-blue-500">
                        </div>
                        
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="text-[9px] font-black text-slate-400 uppercase ml-1 mb-1 block">Jam Mulai</label>
                                <input type="time" name="jam_mulai" required class="w-full bg-white border border-slate-200/60 py-2.5 px-4 rounded-xl text-xs font-bold outline-none focus:border-blue-500">
                            </div>
                            <div>
                                <label class="text-[9px] font-black text-slate-400 uppercase ml-1 mb-1 block">Jam Selesai</label>
                                <input type="time" name="jam_selesai" required class="w-full bg-white border border-slate-200/60 py-2.5 px-4 rounded-xl text-xs font-bold outline-none focus:border-blue-500">
                            </div>
                        </div>

                        <div>
                            <label class="text-[9px] font-black text-slate-400 uppercase ml-1 mb-1 block">Upload KTM (PDF/Gambar)</label>
                            <div class="relative flex items-center justify-center w-full">
                                <label :class="ktmFile ? 'border-emerald-400 bg-emerald-50/20' : 'border-slate-200 bg-white'" class="flex flex-col items-center justify-center w-full h-24 border-2 border-dashed rounded-xl cursor-pointer hover:bg-slate-50/50 transition-all duration-200">
                                    <div class="flex flex-col items-center justify-center pt-3 pb-3 text-center px-4">
                                        <template x-if="!ktmFile">
                                            <div class="contents">
                                                <i class="fas fa-cloud-upload-alt text-xl text-slate-400 mb-1"></i>
                                                <p class="text-[10px] text-slate-500 font-bold">Klik untuk unggah file KTM</p>
                                                <p class="text-[8px] text-slate-400 mt-0.5">Maksimal ukuran 2MB</p>
                                            </div>
                                        </template>
                                        <template x-if="ktmFile">
                                            <div class="contents">
                                                <i class="fas fa-check-circle text-2xl text-emerald-500 mb-1 animate-bounce"></i>
                                                <p class="text-[10px] text-emerald-600 font-black uppercase tracking-wider">File KTM Terpilih!</p>
                                                <p class="text-[9px] text-slate-600 font-medium truncate max-w-[280px] mt-0.5" x-text="ktmFile"></p>
                                            </div>
                                        </template>
                                    </div>
                                    <input type="file" name="ktm" required class="hidden" accept="image/*,application/pdf" @change="ktmFile = $event.target.files[0] ? $event.target.files[0].name : ''">
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3.5 rounded-xl uppercase tracking-wider text-xs shadow-md shadow-blue-600/10 hover:bg-blue-700 transition-all active:scale-95">
                        Ajukan Sekarang
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div x-show="openSchedule" x-cloak class="fixed inset-0 z-[60] flex items-center justify-center p-4">
        <div x-show="openSchedule" x-transition.opacity class="fixed inset-0 bg-[#0B0A4E]/80 backdrop-blur-md" @click="openSchedule = false"></div>
        <div x-show="openSchedule" x-transition.scale.95 class="bg-white w-full max-w-5xl rounded-[40px] overflow-hidden shadow-2xl relative z-10 border border-white">
            <div class="p-8 border-b border-gray-100 flex flex-col sm:flex-row justify-between sm:items-center gap-4">
                <div>
                    <h3 class="text-xl font-black text-[#0B0A4E] uppercase tracking-tighter">Monitoring Jadwal Ruangan</h3>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Jadwal Tanggal: <span class="text-blue-600 italic">{{ request('filter_date', date('Y-m-d')) }}</span></p>
                </div>
                
                <form method="GET" action="{{ route('mahasiswa.dashboard') }}" class="flex items-center gap-2 bg-slate-50 p-2 rounded-2xl border border-slate-200">
                    <input type="hidden" name="open_schedule" value="1">
                    <label class="text-[10px] font-black text-[#0B0A4E] uppercase tracking-wider pl-2">Pilih Tanggal:</label>
                    <input type="date" name="filter_date" value="{{ request('filter_date', date('Y-m-d')) }}" onchange="this.form.submit()" class="bg-white border border-slate-200 py-1.5 px-3 rounded-xl text-xs font-bold text-slate-700 outline-none focus:border-blue-500">
                </form>
                
                <button @click="openSchedule = false" class="text-gray-400 hover:text-red-500 transition-colors"><i class="fas fa-times-circle text-2xl"></i></button>
            </div>
            <div class="p-8 overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr>
                            <th class="p-3 text-left text-[10px] font-black uppercase text-gray-400 border-b w-40 tracking-widest">Nama Ruangan</th>
                            @for($i=6; $i<=18; $i++)
                            <th class="p-3 text-center text-[10px] font-black uppercase text-gray-400 border-b border-l">{{ sprintf('%02d', $i) }}:00</th>
                            @endfor
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rooms as $room)
                        <tr class="hover:bg-gray-50/50">
                            <td class="p-4 text-xs font-extrabold text-[#0B0A4E] border-b uppercase">{{ $room->nama_ruangan }}</td>
                            @for($i=6; $i<=18; $i++)
                            @php
                                $jamSekarang = sprintf('%02d:00', $i);
                                $isBooked = $all_peminjaman->where('room_id', $room->_id)->filter(function($p) use ($jamSekarang) {
                                    return $jamSekarang >= $p->jam_mulai && $jamSekarang < $p->jam_selesai;
                                })->first();
                            @endphp
                            <td class="p-2 border-b border-l text-center min-w-[65px]">
                                @if($isBooked)
                                    <div class="w-full h-10 bg-red-500 rounded-xl flex items-center justify-center group relative cursor-help shadow-sm shadow-red-200" title="Dipesan oleh: {{ $isBooked->user_name }}">
                                        <i class="fas fa-user text-[10px] text-white"></i>
                                    </div>
                                @else
                                    <div class="w-full h-10 bg-emerald-50 rounded-xl border-2 border-emerald-100 border-dashed"></div>
                                @endif
                            </td>
                            @endfor
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-6 bg-gray-50 flex gap-8 justify-center border-t">
                <div class="flex items-center gap-3"><div class="w-5 h-5 bg-red-500 rounded-lg"></div><span class="text-[9px] font-black uppercase text-gray-500 italic">Terpakai</span></div>
                <div class="flex items-center gap-3"><div class="w-5 h-5 bg-emerald-50 border-2 border-emerald-100 border-dashed rounded-lg"></div><span class="text-[9px] font-black uppercase text-gray-500 italic">Ready</span></div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('submit', function(e) {
            // Cek jika form yang sedang di-submit adalah form booking kita bray
            if (e.target && e.target.id === 'formAjukanBooking') {
                e.preventDefault();
                
                const currentForm = e.target;
                const btn = currentForm.querySelector('button[type="submit"]');
                btn.disabled = true; 
                btn.innerHTML = `<i class="fas fa-circle-notch fa-spin mr-2"></i> Memproses...`;

                const roomData = Alpine.$data(document.querySelector('[x-data]')).selectedRoom;
                
                // KOENTJI UTAMA: Menggunakan e.target langsung biar file biner beneran ke-grab!
                let formData = new FormData(currentForm);
                formData.append('room_id', roomData._id || roomData.id); 
                formData.append('room_name', roomData.nama_ruangan);

                fetch("{{ route('peminjaman.ajukan') }}", {
                    method: "POST",
                    body: formData,
                    headers: { 
                        'X-CSRF-TOKEN': "{{ csrf_token() }}", 
                        'Accept': 'application/json' 
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if(data.success) {
                        Swal.fire({
                            icon: 'success', title: 'PENGAJUAN BERHASIL',
                            text: 'Permohonan peminjaman ruangan telah diteruskan ke sistem.',
                            confirmButtonColor: '#0B0A4E', confirmButtonText: 'LIHAT RIWAYAT',
                            customClass: { popup: 'rounded-[30px]', confirmButton: 'rounded-xl font-bold text-xs px-6 py-3' }
                        }).then(() => window.location.href = "{{ route('mahasiswa.peminjaman') }}");
                    } else {
                        Swal.fire({ icon: 'error', title: 'PENGAJUAN GAGAL', text: data.message, confirmButtonColor: '#EF4444', customClass: { popup: 'rounded-[30px]' } });
                        btn.disabled = false; btn.innerText = "Ajukan Sekarang";
                    }
                })
                .catch(() => {
                    Swal.fire({ icon: 'warning', title: 'GANGGUAN SISTEM', text: 'Koneksi terputus.', confirmButtonColor: '#0B0A4E', customClass: { popup: 'rounded-[30px]' } });
                    btn.disabled = false; btn.innerText = "Ajukan Sekarang";
                });
            }
        });
    </script>
</body>
</html>