<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - SMPN 19 Makassar</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-tr from-sky-600 via-primary-600 to-indigo-900 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md bg-white/10 backdrop-blur-xl rounded-3xl border border-white/20 p-8 shadow-2xl relative overflow-hidden">
        
        <div class="flex flex-col items-center mb-8">
            <div class="w-16 h-16 rounded-2xl bg-white/20 flex items-center justify-center text-white text-3xl font-extrabold shadow-inner border border-white/30 mb-4">
                <i class="fa-solid fa-lock-open"></i>
            </div>
            <h1 class="text-2xl font-black text-white text-center tracking-tight leading-tight">RESET PASSWORD</h1>
            <p class="text-xs text-sky-200 mt-1 text-center font-medium">Buat password baru Anda yang aman.</p>
        </div>

        <x-alert />

        <form action="{{ route('password.update') }}" method="POST" class="space-y-4">
            @csrf
            
            <input type="hidden" name="token" value="{{ $token }}">

            <!-- Email -->
            <div>
                <label class="block text-xs font-bold text-sky-100 uppercase tracking-wider mb-1.5">Alamat Email</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-sky-200">
                        <i class="fa-solid fa-envelope"></i>
                    </span>
                    <input 
                        type="email" 
                        name="email" 
                        value="{{ $email ?? old('email') }}" 
                        required 
                        readonly
                        class="w-full bg-white/5 border border-white/10 rounded-2xl py-2.5 pl-10 pr-4 text-sky-300 focus:outline-none text-sm cursor-not-allowed"
                    >
                </div>
            </div>

            <!-- Password Baru -->
            <div>
                <label class="block text-xs font-bold text-sky-100 uppercase tracking-wider mb-1.5">Password Baru</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-sky-200">
                        <i class="fa-solid fa-lock"></i>
                    </span>
                    <input 
                        type="password" 
                        name="password" 
                        required 
                        class="w-full bg-white/15 border border-white/10 rounded-2xl py-2.5 pl-10 pr-4 text-white placeholder-sky-200 focus:outline-none focus:ring-2 focus:ring-white/40 focus:border-transparent transition duration-200 text-sm" 
                        placeholder="••••••••"
                    >
                </div>
            </div>

            <!-- Konfirmasi Password -->
            <div>
                <label class="block text-xs font-bold text-sky-100 uppercase tracking-wider mb-1.5">Konfirmasi Password Baru</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-sky-200">
                        <i class="fa-solid fa-check-double"></i>
                    </span>
                    <input 
                        type="password" 
                        name="password_confirmation" 
                        required 
                        class="w-full bg-white/15 border border-white/10 rounded-2xl py-2.5 pl-10 pr-4 text-white placeholder-sky-200 focus:outline-none focus:ring-2 focus:ring-white/40 focus:border-transparent transition duration-200 text-sm" 
                        placeholder="••••••••"
                    >
                </div>
            </div>

            <!-- Submit Button -->
            <button 
                type="submit" 
                class="w-full bg-white text-primary-600 hover:bg-sky-50 font-bold py-3 px-4 rounded-2xl transition duration-200 shadow-lg shadow-sky-950/20 active:scale-95 text-sm mt-2"
            >
                Simpan Password Baru
            </button>
        </form>

    </div>
</body>
</html>
