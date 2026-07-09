<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SMPN 19 Makassar</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-tr from-sky-600 via-primary-600 to-indigo-900 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md bg-white/10 backdrop-blur-xl rounded-3xl border border-white/20 p-8 shadow-2xl relative overflow-hidden">
        
        <!-- School Crest/Icon Placeholder -->
        <div class="flex flex-col items-center mb-8">
            <div class="w-16 h-16 rounded-2xl bg-white/20 flex items-center justify-center text-white text-3xl font-extrabold shadow-inner border border-white/30 mb-4 animate-bounce">
                <i class="fa-solid fa-graduation-cap"></i>
            </div>
            <h1 class="text-2xl font-black text-white text-center tracking-tight leading-tight">SMP NEGERI 19 MAKASSAR</h1>
            <p class="text-xs text-sky-200 mt-1 uppercase tracking-wider font-semibold">Sistem Presensi & Penjadwalan</p>
        </div>

        <!-- Session Alert -->
        <x-alert />

        <form action="{{ route('login') }}" method="POST" class="space-y-5">
            @csrf
            
            <!-- Email -->
            <div>
                <label class="block text-xs font-bold text-sky-100 uppercase tracking-wider mb-2">Alamat Email</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-sky-200">
                        <i class="fa-solid fa-envelope"></i>
                    </span>
                    <input 
                        type="email" 
                        name="email" 
                        required 
                        value="{{ old('email') }}"
                        class="w-full bg-white/15 border border-white/10 rounded-2xl py-3 pl-10 pr-4 text-white placeholder-sky-200 focus:outline-none focus:ring-2 focus:ring-white/40 focus:border-transparent transition duration-200 text-sm" 
                        placeholder="masukkan@email.com"
                    >
                </div>
            </div>

            <!-- Password -->
            <div>
                <div class="flex justify-between items-center mb-2">
                    <label class="block text-xs font-bold text-sky-100 uppercase tracking-wider">Password</label>
                    <a href="{{ route('password.request') }}" class="text-xs text-sky-200 hover:text-white transition font-medium">Lupa Password?</a>
                </div>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-sky-200">
                        <i class="fa-solid fa-lock"></i>
                    </span>
                    <input 
                        type="password" 
                        name="password" 
                        required 
                        class="w-full bg-white/15 border border-white/10 rounded-2xl py-3 pl-10 pr-4 text-white placeholder-sky-200 focus:outline-none focus:ring-2 focus:ring-white/40 focus:border-transparent transition duration-200 text-sm" 
                        placeholder="••••••••"
                    >
                </div>
            </div>

            <!-- Remember Me -->
            <div class="flex items-center">
                <input 
                    type="checkbox" 
                    name="remember" 
                    id="remember"
                    class="rounded border-white/20 bg-white/15 text-primary-500 focus:ring-0 focus:ring-offset-0 w-4 h-4 cursor-pointer"
                >
                <label for="remember" class="ml-2 text-xs font-semibold text-sky-100 cursor-pointer select-none">Ingat saya di perangkat ini</label>
            </div>

            <!-- Submit Button -->
            <button 
                type="submit" 
                class="w-full bg-white text-primary-600 hover:bg-sky-50 font-bold py-3.5 px-4 rounded-2xl transition duration-200 shadow-lg shadow-sky-950/20 active:scale-95 text-sm"
            >
                Masuk ke Aplikasi
            </button>
        </form>

        <!-- Footer -->
        <div class="mt-8 text-center border-t border-white/10 pt-6">
            <p class="text-xs text-sky-200">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="text-white font-bold hover:underline transition">Daftar sekarang</a>
            </p>
        </div>

    </div>
</body>
</html>
