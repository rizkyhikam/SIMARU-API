<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Mahasiswa - SIMARU</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="h-screen w-full bg-[#F3F6FF] flex items-center justify-center overflow-hidden">

    <div class="w-full h-full flex overflow-hidden">
        
        <div class="w-[45%] bg-[#0B0A4E] relative flex flex-col items-center justify-center p-20 text-center">
            
            <a href="/" class="absolute top-10 left-10 w-12 h-12 bg-white/10 hover:bg-white/20 rounded-2xl flex items-center justify-center text-white transition-all group">
                <i class="fas fa-chevron-left group-hover:-translate-x-1 transition-transform"></i>
            </a>

            <div class="flex-grow flex flex-col items-center justify-center">
                <div class="w-24 h-24 bg-white/5 rounded-[30px] flex items-center justify-center mb-10 border border-white/10">
                    <i class="fas fa-university text-4xl text-cyan-400"></i>
                </div>
                <h1 class="text-6xl font-black text-white tracking-tighter uppercase mb-2">SIMARU</h1>
                <p class="text-cyan-400 text-xs font-black uppercase tracking-[0.4em]">Student Portal Access</p>
                <div class="w-20 h-1.5 bg-cyan-400 rounded-full mt-10 opacity-40"></div>
            </div>

            <div class="w-full border-t border-white/5 pt-10">
                <p class="text-[10px] text-white/40 font-medium uppercase tracking-[0.2em] leading-relaxed">
                    SELAMAT DATANG KEMBALI MAHASISWA<br>
                    SEKOLAH VOKASI IPB UNIVERSITY
                </p>
            </div>
        </div>

        <div class="w-[55%] bg-white flex flex-col justify-center px-32 relative">
    
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-100 text-emerald-600 px-6 py-4 rounded-2xl mb-8 text-[11px] font-bold text-center uppercase tracking-widest shadow-sm">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
    <div class="bg-red-50 border border-red-100 text-red-600 px-6 py-4 rounded-2xl mb-8 text-[11px] font-bold text-center uppercase tracking-widest shadow-sm">
        <i class="fas fa-exclamation-circle mr-2"></i> {{ $errors->first() }}
    </div>
@endif

    <div class="mb-14">
        <h2 class="text-5xl font-black text-[#0B0A4E] tracking-tighter mb-2 uppercase">Login Akun</h2>
        <p class="text-gray-400 text-xs font-black uppercase tracking-[0.3em]">Masukkan Email dan Kata Sandi Anda</p>
    </div>

            <form action="{{ route('mahasiswa.login') }}" method="POST" class="space-y-8">
                @csrf
                
                <div class="relative">
                    <label class="text-[11px] font-black text-[#0B0A4E] uppercase ml-7 mb-3 block tracking-widest opacity-40">Email Mahasiswa</label>
                    <div class="relative">
                        <i class="fas fa-envelope absolute left-7 top-1/2 -translate-y-1/2 text-cyan-500 text-sm"></i>
                        <input type="email" name="email" required class="w-full bg-[#F3F6FF] border border-transparent px-16 py-6 rounded-[30px] focus:bg-white focus:ring-4 focus:ring-indigo-500/5 focus:border-indigo-100 transition-all text-sm font-semibold" placeholder="Masukkan email...">
                    </div>
                </div>

                <div class="relative">
                    <div class="flex justify-between items-center px-7 mb-3">
                        <label class="text-[11px] font-black text-[#0B0A4E] uppercase tracking-widest opacity-40">Password</label>
                    </div>
                    <div class="relative">
                        <i class="fas fa-lock absolute left-7 top-1/2 -translate-y-1/2 text-cyan-500 text-sm"></i>
                        <input type="password" name="password" required class="w-full bg-[#F3F6FF] border border-transparent px-16 py-6 rounded-[30px] focus:bg-white focus:ring-4 focus:ring-indigo-500/5 focus:border-indigo-100 transition-all text-sm font-semibold" placeholder="••••••••">
                    </div>
                </div>

                <div class="pt-4 flex flex-col items-center gap-8">
                    <button type="submit" class="w-full bg-[#0B0A4E] hover:bg-cyan-400 text-white hover:text-[#0B0A4E] font-black py-6 rounded-[30px] transition-all shadow-2xl shadow-indigo-900/20 uppercase text-xs tracking-[0.3em] active:scale-[0.98] group flex items-center justify-center gap-3">
                        <span>Masuk Sekarang</span>
                        <i class="fas fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
                    </button>
                    
                    <p class="text-[12px] font-bold text-gray-400 tracking-wide">
                        Don't have an account yet? 
                        <a href="{{ route('mahasiswa.register') }}" class="text-[#0B0A4E] font-black border-b-2 border-[#0B0A4E] hover:text-cyan-600 hover:border-cyan-600 transition-all ml-1 pb-0.5">Sign Up Here</a>
                    </p>
                </div>
            </form>

        </div>
    </div>

</body>
</html>