<!DOCTYPE html>
<html lang="id" x-data="{ 
    search: '', 
    showDelete: false, 
    showAdd: false,
    selectedId: '', 
    selectedName: '',
    newAdmin: { nama: '', email: '', password: '' }
}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Admin - SIMARU</title>
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
<body class="bg-[#F8FAFC] min-h-screen">

    <div class="bg-navy-dark pt-20 pb-44 px-10 rounded-b-[60px] relative overflow-hidden">
        <div class="absolute top-0 right-0 w-1/2 h-full bg-gradient-to-l from-white/5 to-transparent"></div>
        
        <div class="max-w-6xl mx-auto relative z-10">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div class="text-left">
                    <div class="flex items-center space-x-3 mb-4">
                        <a href="{{ route('admin.menu') }}" class="text-white/50 hover:text-white transition-colors">
                            <i class="fas fa-arrow-left text-xl"></i>
                        </a>
                        <span class="h-1 w-8 bg-cyan-400 rounded-full"></span>
                        <p class="text-cyan-400 font-bold text-[10px] uppercase tracking-[0.3em]">Management</p>
                    </div>
                    <h1 class="text-5xl md:text-7xl font-black text-white tracking-tight leading-none">
                        Kelola <br class="md:hidden"> <span class="text-transparent bg-clip-text bg-gradient-to-r from-white to-white/40">Pengguna.</span>
                    </h1>
                </div>

                <div class="bg-white/10 backdrop-blur-md p-6 rounded-[30px] border border-white/10">
                    <p class="text-white/50 text-[10px] font-bold uppercase mb-1">Total Administrator</p>
                    @php try { $count = \App\Models\Admin::count(); } catch(\Exception $e) { $count = 0; } @endphp
                    <h2 class="text-4xl font-black text-white leading-none">{{ $count }}</h2>
                </div>
            </div>
        </div>
    </div>
    
    <div class="max-w-6xl mx-auto px-10 -mt-16 relative z-20">
        
        <div class="flex flex-col md:flex-row gap-4 mb-12">
            <div class="relative flex-1 group">
                <i class="fas fa-search absolute left-6 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-blue-500 transition-colors"></i>
                <input type="text" x-model="search" placeholder="Cari nama admin..." 
                       class="w-full bg-white py-5 pl-16 pr-8 rounded-3xl shadow-xl border-none outline-none font-bold text-[#0B0A4E] focus:ring-4 focus:ring-blue-500/5 transition-all">
            </div>
            
            <button @click="showAdd = true" class="bg-cyan-400 hover:bg-cyan-300 text-navy-dark px-10 py-5 rounded-3xl font-black text-xs uppercase tracking-widest shadow-xl shadow-cyan-400/20 transition-all active:scale-95 flex items-center justify-center space-x-3">
                <i class="fas fa-plus-circle text-lg"></i>
                <span>Add Admin</span>
            </button>
        </div>

        @php try { $admins = \App\Models\Admin::all(); } catch(\Exception $e) { $admins = collect(); } @endphp
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($admins as $adm)
            <div x-show="search === '' || '{{ strtolower($adm->nama) }}'.includes(search.toLowerCase())" 
                 class="bg-white rounded-[40px] p-8 border border-gray-100 card-shadow transition-all hover:-translate-y-2 group"
                 x-transition>
                
                <div class="flex items-center space-x-6 mb-8">
                    <div class="w-20 h-20 bg-navy-dark rounded-[28px] flex items-center justify-center text-white text-3xl font-black shadow-lg group-hover:bg-blue-600 transition-colors">
                        {{ substr($adm->nama, 0, 1) }}
                    </div>
                    <div class="min-w-0 flex-1">
                        <h4 class="font-extrabold text-[#0B0A4E] text-xl truncate leading-tight">{{ $adm->nama }}</h4>
                        <p class="text-[10px] font-black text-gray-300 uppercase tracking-widest mt-1">Administrator</p>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-2xl p-4 mb-8 flex items-center space-x-3 border border-gray-100">
                    <i class="fas fa-envelope text-blue-500 text-xs"></i>
                    <p class="text-[11px] font-bold text-gray-500 truncate">{{ $adm->email }}</p>
                </div>

                <button @click="selectedId = '{{ (string)$adm->_id }}'; selectedName = '{{ $adm->nama }}'; showDelete = true" 
                        class="w-full py-4 rounded-2xl text-[10px] font-black uppercase tracking-widest text-red-400 hover:bg-red-50 hover:text-red-500 transition-all active:scale-95 border border-dashed border-red-100 hover:border-red-200">
                    <i class="fas fa-trash-alt mr-2"></i> Delete Account
                </button>
            </div>
            @endforeach
        </div>
    </div>

    <div x-show="showAdd" class="fixed inset-0 z-[100] flex items-center justify-center bg-navy-dark/60 backdrop-blur-sm px-6" x-cloak x-transition>
        <div class="bg-white rounded-[45px] p-10 max-w-md w-full shadow-2xl" @click.outside="showAdd = false">
            <h3 class="text-3xl font-black text-navy-dark mb-2 tracking-tighter text-center">New Admin</h3>
            <p class="text-gray-400 text-center text-sm mb-8">Daftarkan admin baru untuk SIMARU.</p>
            <div class="space-y-4">
                <input type="text" x-model="newAdmin.nama" placeholder="Full Name" class="w-full bg-gray-50 py-4 px-6 rounded-2xl outline-none font-bold text-sm text-navy-dark focus:ring-2 focus:ring-cyan-400/20 transition-all border-none">
                <input type="email" x-model="newAdmin.email" placeholder="Email Address" class="w-full bg-gray-50 py-4 px-6 rounded-2xl outline-none font-bold text-sm text-navy-dark focus:ring-2 focus:ring-cyan-400/20 transition-all border-none">
                <input type="password" x-model="newAdmin.password" placeholder="Create Password" class="w-full bg-gray-50 py-4 px-6 rounded-2xl outline-none font-bold text-sm text-navy-dark focus:ring-2 focus:ring-cyan-400/20 transition-all border-none">
            </div>
            <div class="flex space-x-3 mt-10">
                <button @click="showAdd = false" class="flex-1 py-4 text-gray-400 font-bold text-xs uppercase">Cancel</button>
                <button @click="tambahAdmin()" class="flex-1 bg-navy-dark text-white py-4 rounded-2xl font-black text-xs uppercase shadow-xl">Create</button>
            </div>
        </div>
    </div>

    <div x-show="showDelete" class="fixed inset-0 z-[100] flex items-center justify-center bg-navy-dark/60 backdrop-blur-sm px-6" x-cloak x-transition>
        <div class="bg-white rounded-[40px] p-10 max-w-sm w-full text-center shadow-2xl" @click.outside="showDelete = false">
            <h3 class="text-2xl font-black text-navy-dark mb-2 tracking-tight">Hapus Akses?</h3>
            <p class="text-sm text-gray-400 mb-8 leading-relaxed font-medium px-4">Admin <span class="text-red-500 font-bold" x-text="selectedName"></span> tidak akan bisa login lagi.</p>
            <div class="flex space-x-3">
                <button @click="showDelete = false" class="flex-1 py-4 text-gray-400 font-bold text-xs uppercase">Batal</button>
                <button @click="hapusUser()" class="flex-1 bg-red-500 text-white py-4 rounded-2xl font-black text-xs uppercase shadow-xl shadow-red-200">Ya, Hapus</button>
            </div>
        </div>
    </div>

    <script>
        function tambahAdmin() {
            const data = Alpine.$data(document.querySelector('[x-data]')).newAdmin;
            if(!data.nama || !data.email || !data.password) return alert("Lengkapi data bray!");
            fetch('/pengguna/admin/simpan', {
                method: "POST",
                headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}", 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            }).then(res => res.json()).then(data => {
                if(data.success) window.location.reload();
                else alert(data.message);
            });
        }
        function hapusUser() {
            const id = Alpine.$data(document.querySelector('[x-data]')).selectedId;
            fetch(`/pengguna/admin/hapus/${id}`, {
                method: "POST",
                headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}", 'Content-Type': 'application/json' },
                body: JSON.stringify({ _method: 'DELETE' })
            }).then(res => res.json()).then(data => { if(data.success) window.location.reload(); });
        }
    </script>
</body>
</html>