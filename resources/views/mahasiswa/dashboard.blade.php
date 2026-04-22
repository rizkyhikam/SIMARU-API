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
        ::-webkit-scrollbar-thumb { background: #0B0A4E; border-radius: 10px; }
        .glass-card { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.5); }
    </style>
</head>
<body class="bg-[#F8FAFC]" x-data="{ openModal: false, openSchedule: false, selectedRoom: {} }">

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

        <main class="flex-grow h-full overflow-y-auto overflow-x-hidden relative bg-[#F8FAFC]">
            <div class="bg-gradient-to-br from-[#0B0A4E] via-blue-700 to-cyan-500 p-10 pb-28 relative w-full">
                <div class="absolute top-0 right-0 w-1/3 h-full bg-white/5 skew-x-[-20deg] translate-x-20"></div>
                <div class="text-white relative z-10">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="w-8 h-[2px] bg-cyan-400"></span>
                        <p class="text-[10px] font-black uppercase tracking-[0.3em] text-cyan-300">Dashboard Mahasiswa</p>
                    </div>
                    <h2 class="text-4xl font-black tracking-tight uppercase leading-none">Halo, {{ Auth::user()->name }}!</h2>
                    <p class="text-xs opacity-70 mt-2 font-medium">{{ Auth::user()->email }}</p>
                </div>

                <div class="grid grid-cols-2 gap-8 mt-10 absolute -bottom-16 left-10 right-10 z-20">
                    <div class="glass-card p-7 rounded-[35px] shadow-[0_20px_50px_rgba(0,0,0,0.05)] flex items-center justify-between group hover:translate-y-[-5px] transition-all">
                        <div class="flex items-center gap-6">
                            <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-700 rounded-[22px] flex items-center justify-center shadow-lg">
                                <i class="fas fa-door-open text-xl text-white"></i>
                            </div>
                            <div class="min-w-0">
                                <p class="text-[9px] font-extrabold uppercase tracking-[0.2em] text-gray-400 mb-1">Total Ruangan</p>
                                <h3 class="text-4xl font-black text-[#0B0A4E] tracking-tighter">{{ $rooms->count() }}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="glass-card p-7 rounded-[35px] shadow-[0_20px_50px_rgba(0,0,0,0.05)] flex items-center justify-between group hover:translate-y-[-5px] transition-all">
                        <div class="flex items-center gap-6">
                            <div class="w-14 h-14 bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-[22px] flex items-center justify-center shadow-lg">
                                <i class="fas fa-check-circle text-xl text-white"></i>
                            </div>
                            <div class="min-w-0">
                                <p class="text-[9px] font-extrabold uppercase tracking-[0.2em] text-gray-400 mb-1">Ruang Tersedia</p>
                                <h3 class="text-4xl font-black text-[#0B0A4E] tracking-tighter">{{ $rooms->where('status', 'Tersedia')->count() }}</h3>
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

                <div class="grid grid-cols-1 gap-6 w-full">
                    @forelse($rooms as $room)
                    <div class="bg-white p-5 rounded-[40px] shadow-sm border border-gray-50 flex flex-col md:flex-row items-center gap-8 hover:shadow-xl hover:translate-y-[-2px] transition-all duration-300 w-full">
                        <div class="w-full md:w-56 h-40 overflow-hidden rounded-[30px] shadow-inner flex-shrink-0 relative">
                            <img src="{{ $room->image ? asset('storage/' . $room->image) : 'https://via.placeholder.com/400x280?text=No+Image' }}" class="w-full h-full object-cover">
                        </div>
                        <div class="flex-grow text-center md:text-left min-w-0">
                            <h4 class="text-2xl font-black text-[#0B0A4E] uppercase tracking-tight mb-3 truncate">{{ $room->nama_ruangan }}</h4>
                            <div class="flex flex-wrap justify-center md:justify-start items-center gap-3">
                                <span class="{{ $room->status == 'Tersedia' ? 'bg-emerald-50 text-emerald-600' : 'bg-red-50 text-red-600' }} text-[9px] font-black px-5 py-2 rounded-full uppercase border border-current opacity-70">
                                    {{ $room->status }}
                                </span>
                                <span class="bg-blue-50 text-blue-600 text-[9px] font-black px-5 py-2 rounded-full uppercase">
                                    <i class="fas fa-users mr-1.5"></i> {{ $room->kapasitas }} Orang
                                </span>
                            </div>
                        </div>
                        <div class="w-full md:w-auto px-4">
                            <button @click="openModal = true; selectedRoom = {{ json_encode($room) }}" class="w-full md:w-auto bg-[#0B0A4E] hover:bg-blue-700 text-white font-black px-12 py-5 rounded-[25px] text-[10px] uppercase tracking-[0.2em] shadow-xl transition-all">
                                Booking
                            </button>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-20 bg-white rounded-[50px] border-2 border-dashed border-gray-100 text-gray-400 font-bold uppercase text-xs w-full">Belum ada ruangan.</div>
                    @endforelse
                </div>
            </div>
        </main>
    </div>

    <div x-show="openModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div x-show="openModal" x-transition.opacity class="fixed inset-0 bg-[#0B0A4E]/60 backdrop-blur-md" @click="openModal = false"></div>
        <div x-show="openModal" x-transition.scale.95 class="bg-white w-full max-w-md rounded-[45px] overflow-hidden shadow-2xl relative z-10 border border-white">
            <div class="h-52 relative">
                <img :src="selectedRoom.image ? '/storage/' + selectedRoom.image : 'https://via.placeholder.com/400x280'" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                <div class="absolute bottom-6 left-8 text-white">
                    <h3 class="text-2xl font-black uppercase tracking-tighter" x-text="selectedRoom.nama_ruangan"></h3>
                </div>
                <button @click="openModal = false" class="absolute top-6 right-6 text-white/50 hover:text-white transition-colors"><i class="fas fa-times-circle text-2xl"></i></button>
            </div>
            <div class="p-8">
                <div class="mb-6 text-left">
                    <label class="text-[9px] font-black text-gray-400 uppercase ml-2 mb-2 block italic">Jadwal Ruangan Terisi:</label>
                    <div class="space-y-2 max-h-24 overflow-y-auto px-2">
                        <template x-for="p in {{ json_encode($all_peminjaman) }}.filter(item => item.room_id === selectedRoom._id)">
                            <div class="flex items-center justify-between bg-red-50 p-3 rounded-xl border border-red-100">
                                <span class="text-[10px] font-bold text-red-600" x-text="p.tanggal"></span>
                                <span class="text-[10px] font-black text-red-700 bg-white px-2 py-1 rounded-lg" x-text="p.jam_mulai + ' - ' + p.jam_selesai"></span>
                            </div>
                        </template>
                    </div>
                </div>
                <form id="formAjukanBooking" class="space-y-4">
                    @csrf
                    <div class="bg-gray-50 p-6 rounded-[32px] border border-gray-100 space-y-4 text-left">
                        <div>
                            <label class="text-[9px] font-black text-gray-400 uppercase ml-2 mb-1 block">Tanggal</label>
                            <input type="date" name="tanggal" required class="w-full bg-white border border-gray-100 py-4 px-5 rounded-2xl text-xs font-bold outline-none">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-[9px] font-black text-gray-400 uppercase ml-2 mb-1 block">Mulai</label>
                                <input type="time" name="jam_mulai" required class="w-full bg-white border border-gray-100 py-4 px-5 rounded-2xl text-xs font-bold outline-none">
                            </div>
                            <div>
                                <label class="text-[9px] font-black text-gray-400 uppercase ml-2 mb-1 block">Selesai</label>
                                <input type="time" name="jam_selesai" required class="w-full bg-white border border-gray-100 py-4 px-5 rounded-2xl text-xs font-bold outline-none">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="w-full bg-blue-600 text-white font-black py-5 rounded-[25px] uppercase tracking-widest text-[10px] shadow-xl hover:bg-blue-700 transition-all">Ajukan Sekarang</button>
                </form>
            </div>
        </div>
    </div>

    <div x-show="openSchedule" x-cloak class="fixed inset-0 z-[60] flex items-center justify-center p-4">
        <div x-show="openSchedule" x-transition.opacity class="fixed inset-0 bg-[#0B0A4E]/80 backdrop-blur-md" @click="openSchedule = false"></div>
        <div x-show="openSchedule" x-transition.scale.95 class="bg-white w-full max-w-5xl rounded-[40px] overflow-hidden shadow-2xl relative z-10 border border-white">
            <div class="p-8 border-b border-gray-100 flex justify-between items-center">
                <div>
                    <h3 class="text-xl font-black text-[#0B0A4E] uppercase tracking-tighter">Monitoring Jadwal Ruangan</h3>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Ketersediaan Hari Ini (06:00 - 18:00)</p>
                </div>
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
        document.getElementById('formAjukanBooking').addEventListener('submit', function(e) {
            e.preventDefault();
            const btn = this.querySelector('button[type="submit"]');
            btn.disabled = true; 
            btn.innerHTML = `<i class="fas fa-circle-notch fa-spin mr-2"></i> Memproses...`;

            const roomData = Alpine.$data(document.querySelector('[x-data]')).selectedRoom;
            let formData = new FormData(this);
            formData.append('room_id', roomData._id); 
            formData.append('room_name', roomData.nama_ruangan);

            fetch("{{ route('peminjaman.ajukan') }}", {
                method: "POST",
                body: formData,
                headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}", 'Accept': 'application/json' }
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    Swal.fire({
                        icon: 'success', title: 'PENGAJUAN BERHASIL',
                        text: 'Permohonan peminjaman ruangan telah diteruskan ke sistem.',
                        confirmButtonColor: '#0B0A4E', confirmButtonText: 'LIHAT RIWAYAT',
                        customClass: { popup: 'rounded-[40px]', confirmButton: 'rounded-2xl font-black text-[10px] px-8 py-4' }
                    }).then(() => window.location.href = "{{ route('mahasiswa.peminjaman') }}");
                } else {
                    Swal.fire({ icon: 'error', title: 'PENGAJUAN GAGAL', text: data.message, confirmButtonColor: '#EF4444', customClass: { popup: 'rounded-[40px]' } });
                    btn.disabled = false; btn.innerText = "Ajukan Sekarang";
                }
            })
            .catch(() => {
                Swal.fire({ icon: 'warning', title: 'GANGGUAN SISTEM', text: 'Koneksi terputus.', confirmButtonColor: '#0B0A4E', customClass: { popup: 'rounded-[40px]' } });
                btn.disabled = false; btn.innerText = "Ajukan Sekarang";
            });
        });
    </script>
</body>
</html>