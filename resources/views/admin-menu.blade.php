<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Admin - SIMARU</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; letter-spacing: -0.01em; }
        .bg-navy-dark { background-color: #0B0A4E; }
        .card-shadow { box-shadow: 0 10px 40px -10px rgba(0,0,0,0.05); }
    </style>
</head>
<body class="bg-[#F8FAFC] min-h-screen flex flex-col">

    <div class="bg-navy-dark pt-20 pb-44 px-10 rounded-b-[60px] relative overflow-hidden text-white flex-shrink-0">
        <div class="absolute top-0 right-0 w-1/2 h-full bg-gradient-to-l from-white/5 to-transparent"></div>
        <div class="max-w-6xl mx-auto relative z-10 text-center">
            <div class="flex items-center justify-center space-x-3 mb-6">
                <span class="h-1 w-8 bg-cyan-400 rounded-full"></span>
                <p class="text-cyan-400 font-bold text-[10px] uppercase tracking-[0.3em]">Management Area</p>
                <span class="h-1 w-8 bg-cyan-400 rounded-full"></span>
            </div>
            <h1 class="text-5xl md:text-7xl font-black tracking-tight leading-none mb-4 uppercase">
                Menu <span class="text-transparent bg-clip-text bg-gradient-to-r from-white to-white/40">Utama</span>
            </h1>
        </div>
    </div>

    <div class="max-w-6xl mx-auto px-6 -mt-20 relative z-20 flex-grow w-full">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            
            @php $cardClass = "group bg-white p-8 rounded-[40px] card-shadow hover:shadow-2xl transition-all duration-300 flex flex-col items-center text-center border border-white hover:border-cyan-300 h-72 justify-center"; @endphp

            <a href="/dashboard/admin" class="{{ $cardClass }}">
                <div class="w-16 h-16 bg-navy-dark text-white rounded-2xl flex items-center justify-center text-2xl mb-6 group-hover:bg-blue-600 group-hover:rotate-6 transition-all duration-300">
                    <i class="fas fa-chart-pie"></i>
                </div>
                <h3 class="text-xl font-extrabold text-[#0B0A4E]">Dashboard</h3>
                <p class="text-gray-400 text-xs mt-3 px-2 font-medium">Pantau statistik peminjaman hari ini</p>
            </a>

            <a href="{{ route('admin.ruangan') }}" class="{{ $cardClass }}">
                <div class="w-16 h-16 bg-navy-dark text-white rounded-2xl flex items-center justify-center text-2xl mb-6 group-hover:bg-blue-600 group-hover:rotate-6 transition-all duration-300">
                    <i class="fas fa-door-open"></i>
                </div>
                <h3 class="text-xl font-extrabold text-[#0B0A4E]">Kelola Ruangan</h3>
                <p class="text-gray-400 text-xs mt-3 px-2 font-medium">Update ketersediaan kelas & laboratorium</p>
            </a>

            <a href="{{ route('admin.peminjaman') }}" class="{{ $cardClass }}">
                <div class="w-16 h-16 bg-navy-dark text-white rounded-2xl flex items-center justify-center text-2xl mb-6 group-hover:bg-blue-600 group-hover:rotate-6 transition-all duration-300">
                    <i class="fas fa-file-signature"></i>
                </div>
                <h3 class="text-xl font-extrabold text-[#0B0A4E]">Peminjaman</h3>
                <p class="text-gray-400 text-xs mt-3 px-2 font-medium">Konfirmasi pengajuan mahasiswa</p>
            </a>

            <a href="{{ route('admin.pengguna') }}" class="{{ $cardClass }}">
                <div class="w-16 h-16 bg-navy-dark text-white rounded-2xl flex items-center justify-center text-2xl mb-6 group-hover:bg-blue-600 group-hover:rotate-6 transition-all duration-300">
                    <i class="fas fa-users"></i>
                </div>
                <h3 class="text-xl font-extrabold text-[#0B0A4E]">Kelola Pengguna</h3>
                <p class="text-gray-400 text-xs mt-3 px-2 font-medium">Kelola data login & profil admin</p>
            </a>
        </div>
    </div>

    <div class="pb-16 pt-10 flex justify-center flex-shrink-0">
        <a href="/" class="bg-red-500 hover:bg-red-600 text-white px-12 py-5 rounded-[25px] font-black text-xs uppercase tracking-[0.2em] shadow-xl shadow-red-200 transition-all active:scale-95 flex items-center space-x-3 group">
            <i class="fas fa-power-off group-hover:rotate-12 transition-transform"></i>
            <span>    Keluar    </span>
        </a>
    </div>

</body>
</html>