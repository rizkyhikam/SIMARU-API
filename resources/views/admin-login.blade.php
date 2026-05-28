<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - SIMARU</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; letter-spacing: -0.01em; }
        .bg-navy-dark { background-color: #0B0A4E; }
        .bg-gradient-pro { background: linear-gradient(135deg, #0B0A4E 0%, #1e3a8a 100%); }
    </style>
</head>
<body class="min-h-screen flex bg-white overflow-hidden">

    <div class="hidden lg:flex lg:w-1/2 bg-gradient-pro relative items-center justify-center p-20">
        <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-blue-400/20 rounded-full blur-[120px]"></div>
        
        <div class="relative z-10 text-center">
            <div class="w-28 h-28 bg-white rounded-[35px] flex items-center justify-center mb-8 mx-auto border border-white/20 shadow-2xl p-1.5">
                <div class="w-full h-full rounded-[26px] overflow-hidden shadow-inner flex items-center justify-center">
                    <img src="{{ asset('storage/rooms/logo simaru.jpeg') }}" alt="Logo SIMARU" class="w-full h-full object-cover">
                </div>
            </div>
            <h1 class="text-6xl font-black text-white tracking-tighter mb-4">SIMARU</h1>
            <p class="text-blue-200 text-xs font-medium opacity-80 leading-relaxed uppercase tracking-widest">
                Sekolah Vokasi IPB
            </p>
        </div>
    </div>

    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-[#F8FAFC] relative">
        
        <a href="/" class="absolute top-10 left-10 w-12 h-12 bg-white rounded-2xl shadow-xl flex items-center justify-center text-gray-400 hover:text-navy-dark transition-all">
            <i class="fas fa-arrow-left"></i>
        </a>

        <div class="w-full max-w-md" x-data="{ show: false }">
            <div class="mb-10">
                <h2 class="text-4xl font-black text-[#0B0A4E] tracking-tight mb-2">Login Admin</h2>
                <p class="text-gray-400 font-medium text-sm">Masuk untuk mengelola operasional ruangan</p>
            </div>

       <form action="{{ route('admin.login.proses') }}" method="POST" class="space-y-5">
    @csrf

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-[15px] relative text-xs font-bold mb-4">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="space-y-2">
        <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-2">Email Address</label>
        <div class="relative group">
            <i class="fas fa-envelope absolute left-6 top-1/2 -translate-y-1/2 text-gray-300 group-focus-within:text-blue-500 transition-colors"></i>
            <input type="email" name="email" value="{{ old('email') }}" placeholder="admin@simaru.com" required
                   class="w-full bg-white border border-gray-100 py-4 pl-16 pr-6 rounded-[22px] shadow-sm outline-none focus:ring-4 focus:ring-blue-500/5 focus:border-blue-200 font-bold text-[#0B0A4E] transition-all">
        </div>
    </div>

    <div class="space-y-2">
        <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] ml-2">Secure Password</label>
        <div class="relative group">
            <i class="fas fa-lock absolute left-6 top-1/2 -translate-y-1/2 text-gray-300 group-focus-within:text-blue-500 transition-colors"></i>
            <input :type="show ? 'text' : 'password'" name="password" placeholder="••••••••" required
                   class="w-full bg-white border border-gray-100 py-4 pl-16 pr-16 rounded-[22px] shadow-sm outline-none focus:ring-4 focus:ring-blue-500/5 focus:border-blue-200 font-bold text-[#0B0A4E] transition-all">
            <button type="button" @click="show = !show" class="absolute right-6 top-1/2 -translate-y-1/2 text-gray-300 hover:text-blue-500 transition-all">
                <i class="fas" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
            </button>
        </div>
    </div>

    <button type="submit" class="w-full bg-[#0B0A4E] hover:bg-blue-800 text-white py-5 rounded-[22px] font-black text-[10px] uppercase tracking-[0.2em] shadow-2xl shadow-indigo-100 transition-all active:scale-95 flex items-center justify-center space-x-3">
        <span>Masuk</span>
        <i class="fas fa-chevron-right text-[10px]"></i>
    </button>
</form>

            <div class="mt-16 text-center opacity-40">
                <p class="text-[9px] font-black text-gray-400 uppercase tracking-[0.3em]">Sekolah Vokasi IPB • 2026</p>
            </div>
        </div>
    </div>
</body>
</html>