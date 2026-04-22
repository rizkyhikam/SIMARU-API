<!DOCTYPE html>
<html lang="id" x-data="{ 
    openForm: false, 
    showSuccess: false, 
    showEdit: false, 
    showDelete: false,
    selectedRoom: { id: '', nama: '', kapasitas: '', fasilitas: '', image: '' } 
}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Ruangan - SIMARU Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; letter-spacing: -0.01em; }
        [x-cloak] { display: none !important; }
        .bg-navy-dark { background-color: #0B0A4E; }
        .card-shadow { box-shadow: 0 10px 40px -10px rgba(0,0,0,0.05); }
        input::-webkit-outer-spin-button, input::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
    </style>
</head>
<body class="bg-[#F8FAFC] min-h-screen overflow-x-hidden">

    <div class="bg-navy-dark pt-20 pb-44 px-10 rounded-b-[60px] relative overflow-hidden text-white">
        <div class="absolute top-0 right-0 w-1/2 h-full bg-gradient-to-l from-white/5 to-transparent"></div>
        <div class="max-w-7xl mx-auto relative z-10">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div>
                    <div class="flex items-center space-x-3 mb-6">
                        <a href="{{ route('admin.menu') }}" class="text-white/50 hover:text-white transition-colors">
                            <i class="fas fa-arrow-left text-xl"></i>
                        </a>
                        <span class="h-1 w-8 bg-cyan-400 rounded-full"></span>
                        <p class="text-cyan-400 font-bold text-[10px] uppercase tracking-[0.3em]">Manajemen Aset</p>
                    </div>
                    <h1 class="text-5xl md:text-7xl font-black tracking-tight leading-none">
                        Kelola <span class="text-transparent bg-clip-text bg-gradient-to-r from-white to-white/40">Ruangan.</span>
                    </h1>
                </div>
                <button @click="openForm = !openForm" class="bg-cyan-400 hover:bg-white text-[#0B0A4E] px-10 py-5 rounded-[30px] font-black text-xs uppercase tracking-widest shadow-xl transition-all active:scale-95 flex items-center justify-center space-x-3">
                    <i :class="openForm ? 'fas fa-times' : 'fas fa-plus-circle'" class="text-lg"></i>
                    <span x-text="openForm ? 'Batalkan Input' : 'Tambah Ruangan'"></span>
                </button>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-10 -mt-16 relative z-20 pb-20">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            
            <div :class="openForm ? 'lg:col-span-7' : 'lg:col-span-12'" class="transition-all duration-500">
                <div class="bg-white rounded-[50px] card-shadow p-10 border border-gray-50">
                    <h2 class="text-2xl font-black text-[#0B0A4E] mb-10">Daftar Ruangan Aktif</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6" :class="openForm ? 'md:grid-cols-1' : 'md:grid-cols-2'">
                        @forelse($rooms as $room)
                        <div class="group bg-gray-50 p-6 rounded-[35px] border border-transparent hover:border-cyan-200 hover:bg-white hover:shadow-2xl transition-all duration-300">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-5">
                                    <div class="w-20 h-20 bg-navy-dark rounded-[25px] overflow-hidden shadow-lg border-4 border-white flex-shrink-0">
                                        <img src="{{ $room->image ? asset('storage/' . $room->image) : 'https://via.placeholder.com/150' }}" class="w-full h-full object-cover">
                                    </div>
                                    <div class="min-w-0">
                                        <h4 class="font-black text-[#0B0A4E] text-lg truncate uppercase tracking-tighter">{{ $room->nama_ruangan }}</h4>
                                        <div class="flex gap-2 mt-2">
                                            <span class="text-[9px] font-black text-gray-400 bg-white px-3 py-1 rounded-full border border-gray-100 uppercase">
                                                <i class="fas fa-users mr-1 text-cyan-500"></i> {{ $room->kapasitas }} Kursi
                                            </span>
                                            <span class="text-[9px] font-black text-gray-400 bg-white px-3 py-1 rounded-full border border-gray-100 uppercase">
                                                <i class="fas fa-check-circle mr-1 text-green-500"></i> Aktif
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-col space-y-2">
                                    <button @click="selectedRoom = { id: '{{ (string)$room->_id }}', nama: '{{ $room->nama_ruangan }}', kapasitas: '{{ $room->kapasitas }}', fasilitas: '{{ $room->fasilitas }}', image: '{{ $room->image }}' }; showEdit = true;" 
                                            class="w-10 h-10 bg-white text-orange-400 rounded-xl shadow-sm hover:bg-orange-400 hover:text-white transition-all flex items-center justify-center">
                                        <i class="fas fa-pen-nib text-xs"></i>
                                    </button>
                                    <button @click="selectedRoom.id = '{{ (string)$room->_id }}'; showDelete = true;" 
                                            class="w-10 h-10 bg-white text-red-400 rounded-xl shadow-sm hover:bg-red-400 hover:text-white transition-all flex items-center justify-center">
                                        <i class="fas fa-trash-alt text-xs"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-span-full py-20 text-center bg-gray-50 rounded-[40px] border-2 border-dashed border-gray-200">
                            <i class="fas fa-box-open text-5xl text-gray-200 mb-4"></i>
                            <p class="text-gray-400 font-bold uppercase text-[10px] tracking-widest">Database Ruangan Kosong</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div x-show="openForm" x-cloak x-transition.scale.95 class="lg:col-span-5">
                <div class="bg-white rounded-[50px] card-shadow p-10 border-t-[15px] border-cyan-400 sticky top-10">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-12 h-12 bg-cyan-50 rounded-2xl flex items-center justify-center text-cyan-500 text-xl shadow-inner">
                            <i class="fas fa-layer-group"></i>
                        </div>
                        <h3 class="font-black text-[#0B0A4E] text-2xl tracking-tighter uppercase">Input Ruang Baru</h3>
                    </div>

                    <form id="formTambahRuangan" class="space-y-5">
                        @csrf
                        <div class="space-y-1">
                            <label class="text-[9px] font-black text-gray-400 uppercase ml-5 tracking-[0.2em]">Identitas Ruangan</label>
                            <input type="text" name="nama_ruangan" required placeholder="Masukan Nama (Contoh: Lab RPL)" 
                                   class="w-full bg-gray-50 border-2 border-transparent focus:border-cyan-400 focus:bg-white rounded-[25px] p-5 text-sm font-bold text-[#0B0A4E] outline-none transition-all">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <label class="text-[9px] font-black text-gray-400 uppercase ml-5 tracking-[0.2em]">Kapasitas</label>
                            <input type="number" name="kapasitas" required placeholder="Jumlah Kursi" 
                                class="w-full bg-gray-50 border-2 border-transparent focus:border-cyan-400 focus:bg-white rounded-[25px] p-5 text-sm font-bold text-[#0B0A4E] outline-none transition-all">
                        </div>

                        <div class="space-y-1">
                            <label class="text-[9px] font-black text-gray-400 uppercase ml-5 tracking-[0.2em]">Status Awal</label>
                            <div class="w-full bg-emerald-50 border-2 border-emerald-100 rounded-[25px] p-5 flex items-center justify-center gap-2">
                                <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                                <span class="text-sm font-black text-emerald-600 uppercase tracking-tighter">Tersedia</span>
                            </div>
                            <input type="hidden" name="status" value="Tersedia">
                        </div>
                    </div>

                        <div class="space-y-1">
                            <label class="text-[9px] font-black text-gray-400 uppercase ml-5 tracking-[0.2em]">Fasilitas Pendukung</label>
                            <input type="text" name="fasilitas" required placeholder="AC, PC, Proyektor, dll..." 
                                   class="w-full bg-gray-50 border-2 border-transparent focus:border-cyan-400 focus:bg-white rounded-[25px] p-5 text-sm font-bold text-[#0B0A4E] outline-none transition-all">
                        </div>

                        <div class="space-y-2">
                        <label class="text-[9px] font-black text-gray-400 uppercase ml-5 tracking-[0.2em]">Dokumentasi Foto</label>
                        <div class="relative group border-2 border-dashed border-gray-200 rounded-[25px] p-8 text-center hover:bg-cyan-50 hover:border-cyan-400 transition-all cursor-pointer">
                            <input type="file" name="image" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            <i class="fas fa-cloud-upload-alt text-3xl text-gray-300 group-hover:text-cyan-500 mb-2 transition-colors"></i>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Klik Untuk Upload Gambar</p>
                            <p class="text-[8px] font-black text-red-400 uppercase mt-2">* Maksimal ukuran file: 5MB</p>
                        </div>
                    </div>

                        <button type="submit" class="w-full bg-navy-dark text-white py-6 rounded-[30px] font-black text-[11px] uppercase tracking-[0.3em] shadow-2xl hover:bg-blue-600 transition-all active:scale-95">
                            Simpan Data Aset
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div x-show="showEdit" class="fixed inset-0 z-[100] flex items-center justify-center bg-navy-dark/70 backdrop-blur-md px-6" x-cloak x-transition>
        <div class="bg-white rounded-[60px] p-12 max-w-xl w-full shadow-2xl border-t-[15px] border-orange-400 relative max-h-[90vh] overflow-y-auto" @click.outside="showEdit = false">
            <h3 class="font-black text-navy-dark text-3xl mb-10 tracking-tighter text-center uppercase">Update Informasi Ruang</h3>
            <form id="formUpdateRuangan" class="space-y-6">
                @csrf
                <div class="bg-gray-50 p-8 rounded-[40px] flex flex-col items-center gap-6 border border-gray-100">
                    <div class="w-32 h-32 bg-white rounded-[35px] overflow-hidden shadow-2xl border-4 border-white flex-shrink-0">
                        <template x-if="selectedRoom.image"><img :src="'/storage/' + selectedRoom.image" class="w-full h-full object-cover"></template>
                        <template x-if="!selectedRoom.image"><div class="w-full h-full flex items-center justify-center text-gray-100"><i class="fas fa-image text-4xl"></i></div></template>
                    </div>
                    <input type="file" name="image" accept="image/*" class="text-[10px] font-bold text-gray-400">
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <input type="text" name="nama_ruangan" x-model="selectedRoom.nama" placeholder="Nama Ruang" class="w-full bg-gray-50 border-none rounded-[25px] p-5 text-sm font-bold text-navy-dark outline-none">
                    <input type="number" name="kapasitas" x-model="selectedRoom.kapasitas" placeholder="Kapasitas" class="w-full bg-gray-50 border-none rounded-[25px] p-5 text-sm font-bold text-navy-dark outline-none">
                </div>
                <input type="text" name="fasilitas" x-model="selectedRoom.fasilitas" placeholder="Fasilitas" class="w-full bg-gray-50 border-none rounded-[25px] p-5 text-sm font-bold text-navy-dark outline-none">
                <div class="flex gap-4 pt-6">
                    <button type="button" @click="showEdit = false" class="flex-1 font-bold text-gray-400 uppercase text-[10px] tracking-widest">Batal</button>
                    <button type="submit" class="flex-[2] bg-orange-400 text-white py-5 rounded-[25px] font-black uppercase text-[10px] tracking-widest shadow-xl shadow-orange-100">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <div x-show="showDelete" class="fixed inset-0 z-[100] flex items-center justify-center bg-navy-dark/70 backdrop-blur-md px-6" x-cloak x-transition>
        <div class="bg-white rounded-[60px] p-12 max-w-sm w-full text-center shadow-2xl" @click.outside="showDelete = false">
            <div class="w-24 h-24 bg-red-50 text-red-500 rounded-full flex items-center justify-center text-4xl mx-auto mb-8 shadow-inner"><i class="fas fa-exclamation-triangle"></i></div>
            <h3 class="text-2xl font-black text-navy-dark mb-4 uppercase tracking-tighter">Konfirmasi Hapus</h3>
            <p class="text-xs font-bold text-gray-400 mb-10 leading-relaxed uppercase">Tindakan ini permanen. Seluruh data ruangan akan dihapus dari sistem.</p>
            <div class="flex space-x-4">
                <button @click="showDelete = false" class="flex-1 bg-gray-100 py-5 rounded-[25px] font-black text-[10px] uppercase">Batal</button>
                <button @click="hapusData(selectedRoom.id)" class="flex-1 bg-red-500 text-white py-5 rounded-[25px] font-black text-[10px] uppercase shadow-2xl shadow-red-200">Hapus Aset</button>
            </div>
        </div>
    </div>

    <div x-show="showSuccess" class="fixed inset-0 z-[110] flex items-center justify-center bg-navy-dark/70 backdrop-blur-md px-6" x-cloak x-transition>
        <div class="bg-white rounded-[70px] p-16 max-w-sm w-full text-center shadow-2xl">
            <div class="w-24 h-24 bg-green-500 text-white rounded-full flex items-center justify-center text-4xl mx-auto mb-8 shadow-2xl shadow-green-200"><i class="fas fa-check"></i></div>
            <h3 class="text-3xl font-black text-navy-dark mb-10 uppercase tracking-tighter">Data Berhasil Tersinkron!</h3>
            <button @click="location.reload()" class="w-full bg-navy-dark py-5 rounded-[25px] font-black text-white text-[10px] uppercase tracking-widest shadow-2xl">Tutup</button>
        </div>
    </div>

    <script>
        // FUNGSI TAMBAH DATA
        document.getElementById('formTambahRuangan').addEventListener('submit', function(e) {
            e.preventDefault();
            const btn = this.querySelector('button[type="submit"]');
            btn.disabled = true; btn.innerText = "SINKRONISASI DATA...";
            
            fetch("{{ route('admin.ruangan.simpan') }}", {
                method: "POST",
                body: new FormData(this),
                headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}", 'Accept': 'application/json' }
            }).then(res => res.json()).then(data => {
                if(data.success) { window.dispatchEvent(new CustomEvent('tambah-sukses')); Alpine.$data(document.querySelector('[x-data]')).showSuccess = true; }
                else { alert(data.message); btn.disabled = false; btn.innerText = "SIMPAN DATA RUANGAN"; }
            }).catch(err => { console.error(err); btn.disabled = false; btn.innerText = "SIMPAN DATA RUANGAN"; });
        });

        // FUNGSI UPDATE DATA
        document.getElementById('formUpdateRuangan').addEventListener('submit', function(e) {
            e.preventDefault();
            const id = Alpine.$data(document.querySelector('[x-data]')).selectedRoom.id;
            let formData = new FormData(this);
            formData.append('_method', 'PUT'); 

            fetch('/ruangan/admin/update/' + id, {
                method: "POST",
                body: formData,
                headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}", 'Accept': 'application/json' }
            }).then(res => res.json()).then(data => {
                if(data.success) { window.location.reload(); }
                else { alert(data.message); }
            });
        });

        // FUNGSI HAPUS DATA
        function hapusData(id) {
            if (!id) return;
            fetch('/ruangan/admin/hapus/' + id, {
                method: "DELETE",
                headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}", 'Accept': 'application/json' }
            }).then(res => res.json()).then(data => {
                if (data.success) { window.location.reload(); }
                else { alert(data.message); }
            });
        }
    </script>
</body>
</html>