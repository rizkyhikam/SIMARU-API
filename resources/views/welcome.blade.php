<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMARU - Portal Pilihan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background: radial-gradient(circle at top right, #e0e7ff 0%, #f8fafc 100%);
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.8);
        }
    </style>
</head>
<body class="h-screen flex flex-col items-center justify-between py-10 px-6 relative overflow-hidden">

    <div class="fixed top-[-10%] right-[-10%] w-[500px] h-[500px] bg-blue-400/10 rounded-full blur-[120px] -z-10"></div>
    <div class="fixed bottom-[-10%] left-[-10%] w-[500px] h-[500px] bg-indigo-500/10 rounded-full blur-[120px] -z-10"></div>

    <div class="text-center">
        <div class="w-20 h-20 bg-white rounded-[25px] shadow-2xl flex items-center justify-center mb-6 mx-auto border border-white">
            <div class="w-14 h-14 bg-[#0B0A4E] rounded-2xl flex items-center justify-center shadow-lg">
                <i class="fas fa-university text-xl text-white"></i>
            </div>
        </div>
        <h1 class="text-4xl font-[900] text-[#0B0A4E] tracking-tighter mb-1 uppercase">SIMARU</h1>
        <p class="text-gray-400 text-[10px] font-black uppercase tracking-[0.4em]">Sistem Informasi Ruangan</p>
    </div>

    <div class="max-w-md w-full">
        <div class="glass-card rounded-[50px] p-8 md:p-10 shadow-2xl w-full">
            <p class="text-[#0B0A4E] font-black text-[10px] uppercase tracking-widest mb-8 opacity-40 text-center">Login Sebagai</p>
            
            <div class="space-y-4">
                <a href="/login/admin" class="group w-full flex items-center justify-between bg-[#0B0A4E] hover:bg-cyan-400 p-5 rounded-[30px] transition-all duration-300 shadow-xl shadow-indigo-200 hover:-translate-y-1">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-white/10 group-hover:bg-[#0B0A4E]/10 rounded-xl flex items-center justify-center text-white text-lg group-hover:rotate-12 transition-all">
                            <i class="fas fa-user-shield text-cyan-400 group-hover:text-[#0B0A4E]"></i>
                        </div>
                        <div class="text-left">
                            <p class="text-[8px] font-black text-cyan-400 group-hover:text-[#0B0A4E]/60 uppercase tracking-widest">Management</p>
                            <p class="text-base font-black text-white group-hover:text-[#0B0A4E] tracking-tight">Admin</p>
                        </div>
                    </div>
                    <i class="fas fa-chevron-right text-white/30 group-hover:text-[#0B0A4E] transition-colors text-xs"></i>
                </a>

                <a href="/login/mahasiswa" class="group w-full flex items-center justify-between bg-[#0B0A4E] hover:bg-cyan-400 p-5 rounded-[30px] transition-all duration-300 shadow-xl shadow-indigo-900/10 hover:-translate-y-1">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-white/10 group-hover:bg-[#0B0A4E]/10 rounded-xl flex items-center justify-center text-white text-lg group-hover:rotate-12 transition-all">
                            <i class="fas fa-user-graduate text-cyan-400 group-hover:text-[#0B0A4E]"></i>
                        </div>
                        <div class="text-left">
                            <p class="text-[8px] font-black text-cyan-400 group-hover:text-[#0B0A4E]/60 uppercase tracking-widest">Student Portal</p>
                            <p class="text-base font-black text-white group-hover:text-[#0B0A4E] tracking-tight">Mahasiswa</p>
                        </div>
                    </div>
                    <i class="fas fa-chevron-right text-white/30 group-hover:text-[#0B0A4E] transition-colors text-xs"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="text-center">
        <p class="text-gray-300 text-[9px] font-black uppercase tracking-[0.3em] mb-1">Developed By</p>
        <p class="text-[#0B0A4E] font-bold text-[10px] uppercase tracking-widest opacity-60">Sekolah Vokasi IPB • 2026</p>
    </div>

</body>
</html>