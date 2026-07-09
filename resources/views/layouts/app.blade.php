<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - SMPN 19 Makassar</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Vite CSS & JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
        }

        /* Hide scrollbar for Chrome, Safari and Opera */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        /* Hide scrollbar for IE, Edge and Firefox */
        .no-scrollbar {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }
    </style>
</head>
<body class="overflow-x-hidden" x-data="{ sidebarOpen: true }">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside 
            :class="sidebarOpen ? 'w-64' : 'w-20'" 
            class="bg-slate-900 text-slate-400 flex flex-col transition-all duration-300 z-30 shrink-0 h-full relative"
        >
            <!-- Logo Section -->
            <div class="h-16 flex items-center justify-between px-4 border-b border-slate-800 bg-slate-950/40">
                <a href="#" class="flex items-center space-x-3">
                    <div class="w-9 h-9 rounded-xl bg-primary-500 flex items-center justify-center text-white font-bold shadow-lg shadow-primary-500/20">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </div>
                    <span x-show="sidebarOpen" class="font-extrabold text-white text-base tracking-wide uppercase transition-all duration-200">
                        SMPN 19 MKS
                    </span>
                </a>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 px-3 py-4 space-y-1.5 overflow-y-auto no-scrollbar">
                @php
                    $role = Auth::user()->role;
                @endphp

                <!-- ADMIN MENU -->
                @if($role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 rounded-xl hover:bg-slate-800 hover:text-white transition group {{ Route::is('admin.dashboard') ? 'bg-primary-500 text-white font-semibold' : '' }}">
                        <i class="fa-solid fa-chart-line w-6"></i>
                        <span x-show="sidebarOpen" class="ml-3 transition-opacity">Dashboard</span>
                    </a>
                    <a href="{{ route('admin.guru.index') }}" class="flex items-center px-4 py-3 rounded-xl hover:bg-slate-800 hover:text-white transition group {{ Route::is('admin.guru.*') ? 'bg-primary-500 text-white font-semibold' : '' }}">
                        <i class="fa-solid fa-chalkboard-user w-6"></i>
                        <span x-show="sidebarOpen" class="ml-3">Data Guru</span>
                    </a>
                    <a href="{{ route('admin.siswa.index') }}" class="flex items-center px-4 py-3 rounded-xl hover:bg-slate-800 hover:text-white transition group {{ Route::is('admin.siswa.*') ? 'bg-primary-500 text-white font-semibold' : '' }}">
                        <i class="fa-solid fa-user-graduate w-6"></i>
                        <span x-show="sidebarOpen" class="ml-3">Data Siswa</span>
                    </a>
                    <a href="{{ route('admin.wali-siswa.index') }}" class="flex items-center px-4 py-3 rounded-xl hover:bg-slate-800 hover:text-white transition group {{ Route::is('admin.wali-siswa.*') ? 'bg-primary-500 text-white font-semibold' : '' }}">
                        <i class="fa-solid fa-users w-6"></i>
                        <span x-show="sidebarOpen" class="ml-3">Wali Siswa</span>
                    </a>
                    <a href="{{ route('admin.kelas.index') }}" class="flex items-center px-4 py-3 rounded-xl hover:bg-slate-800 hover:text-white transition group {{ Route::is('admin.kelas.*') ? 'bg-primary-500 text-white font-semibold' : '' }}">
                        <i class="fa-solid fa-school w-6"></i>
                        <span x-show="sidebarOpen" class="ml-3">Data Kelas</span>
                    </a>
                    <a href="{{ route('admin.mata-pelajaran.index') }}" class="flex items-center px-4 py-3 rounded-xl hover:bg-slate-800 hover:text-white transition group {{ Route::is('admin.mata-pelajaran.*') ? 'bg-primary-500 text-white font-semibold' : '' }}">
                        <i class="fa-solid fa-book-open w-6"></i>
                        <span x-show="sidebarOpen" class="ml-3">Mata Pelajaran</span>
                    </a>
                    <a href="{{ route('admin.jadwal.index') }}" class="flex items-center px-4 py-3 rounded-xl hover:bg-slate-800 hover:text-white transition group {{ Route::is('admin.jadwal.*') ? 'bg-primary-500 text-white font-semibold' : '' }}">
                        <i class="fa-solid fa-calendar-days w-6"></i>
                        <span x-show="sidebarOpen" class="ml-3">Jadwal Pelajaran</span>
                    </a>
                    <a href="{{ route('admin.qr-code.index') }}" class="flex items-center px-4 py-3 rounded-xl hover:bg-slate-800 hover:text-white transition group {{ Route::is('admin.qr-code.*') ? 'bg-primary-500 text-white font-semibold' : '' }}">
                        <i class="fa-solid fa-qrcode w-6"></i>
                        <span x-show="sidebarOpen" class="ml-3">QR Code Siswa</span>
                    </a>
                    <div class="pt-4 border-t border-slate-800 my-4"></div>
                    <a href="{{ route('admin.presensi.scan') }}" class="flex items-center px-4 py-3 rounded-xl hover:bg-slate-800 hover:text-white transition group {{ Route::is('admin.presensi.scan') ? 'bg-primary-500 text-white font-semibold' : '' }}">
                        <i class="fa-solid fa-camera w-6"></i>
                        <span x-show="sidebarOpen" class="ml-3">Scanner Presensi</span>
                    </a>
                    <a href="{{ route('admin.presensi.index') }}" class="flex items-center px-4 py-3 rounded-xl hover:bg-slate-800 hover:text-white transition group {{ Route::is('admin.presensi.index') ? 'bg-primary-500 text-white font-semibold' : '' }}">
                        <i class="fa-solid fa-clipboard-user w-6"></i>
                        <span x-show="sidebarOpen" class="ml-3">Data Presensi</span>
                    </a>
                    <a href="{{ route('admin.laporan.index') }}" class="flex items-center px-4 py-3 rounded-xl hover:bg-slate-800 hover:text-white transition group {{ Route::is('admin.laporan.*') ? 'bg-primary-500 text-white font-semibold' : '' }}">
                        <i class="fa-solid fa-print w-6"></i>
                        <span x-show="sidebarOpen" class="ml-3">Laporan</span>
                    </a>
                @endif

                <!-- GURU MENU -->
                @if($role === 'guru')
                    <a href="{{ route('guru.dashboard') }}" class="flex items-center px-4 py-3 rounded-xl hover:bg-slate-800 hover:text-white transition group {{ Route::is('guru.dashboard') ? 'bg-primary-500 text-white font-semibold' : '' }}">
                        <i class="fa-solid fa-chart-line w-6"></i>
                        <span x-show="sidebarOpen" class="ml-3">Dashboard</span>
                    </a>
                    <a href="{{ route('guru.jadwal') }}" class="flex items-center px-4 py-3 rounded-xl hover:bg-slate-800 hover:text-white transition group {{ Route::is('guru.jadwal') ? 'bg-primary-500 text-white font-semibold' : '' }}">
                        <i class="fa-solid fa-calendar-week w-6"></i>
                        <span x-show="sidebarOpen" class="ml-3">Jadwal Mengajar</span>
                    </a>
                    <a href="{{ route('guru.scan') }}" class="flex items-center px-4 py-3 rounded-xl hover:bg-slate-800 hover:text-white transition group {{ Route::is('guru.scan') ? 'bg-primary-500 text-white font-semibold' : '' }}">
                        <i class="fa-solid fa-camera w-6"></i>
                        <span x-show="sidebarOpen" class="ml-3">Scan Presensi</span>
                    </a>
                    <a href="{{ route('guru.presensi') }}" class="flex items-center px-4 py-3 rounded-xl hover:bg-slate-800 hover:text-white transition group {{ Route::is('guru.presensi') ? 'bg-primary-500 text-white font-semibold' : '' }}">
                        <i class="fa-solid fa-list-check w-6"></i>
                        <span x-show="sidebarOpen" class="ml-3">Presensi Siswa</span>
                    </a>
                    <a href="{{ route('guru.monitoring') }}" class="flex items-center px-4 py-3 rounded-xl hover:bg-slate-800 hover:text-white transition group {{ Route::is('guru.monitoring') ? 'bg-primary-500 text-white font-semibold' : '' }}">
                        <i class="fa-solid fa-display w-6"></i>
                        <span x-show="sidebarOpen" class="ml-3">Monitoring Kelas</span>
                    </a>
                @endif

                <!-- SISWA MENU -->
                @if($role === 'siswa')
                    <a href="{{ route('siswa.dashboard') }}" class="flex items-center px-4 py-3 rounded-xl hover:bg-slate-800 hover:text-white transition group {{ Route::is('siswa.dashboard') ? 'bg-primary-500 text-white font-semibold' : '' }}">
                        <i class="fa-solid fa-chart-line w-6"></i>
                        <span x-show="sidebarOpen" class="ml-3">Dashboard</span>
                    </a>
                    <a href="{{ route('siswa.jadwal') }}" class="flex items-center px-4 py-3 rounded-xl hover:bg-slate-800 hover:text-white transition group {{ Route::is('siswa.jadwal') ? 'bg-primary-500 text-white font-semibold' : '' }}">
                        <i class="fa-solid fa-calendar-days w-6"></i>
                        <span x-show="sidebarOpen" class="ml-3">Jadwal Kelas</span>
                    </a>
                    <a href="{{ route('siswa.presensi') }}" class="flex items-center px-4 py-3 rounded-xl hover:bg-slate-800 hover:text-white transition group {{ Route::is('siswa.presensi') ? 'bg-primary-500 text-white font-semibold' : '' }}">
                        <i class="fa-solid fa-clock-rotate-left w-6"></i>
                        <span x-show="sidebarOpen" class="ml-3">Riwayat Presensi</span>
                    </a>
                    <a href="{{ route('siswa.qr-code') }}" class="flex items-center px-4 py-3 rounded-xl hover:bg-slate-800 hover:text-white transition group {{ Route::is('siswa.qr-code') ? 'bg-primary-500 text-white font-semibold' : '' }}">
                        <i class="fa-solid fa-qrcode w-6"></i>
                        <span x-show="sidebarOpen" class="ml-3">Kartu QR Code</span>
                    </a>
                @endif

                <!-- WALI MENU -->
                @if($role === 'wali_siswa')
                    <a href="{{ route('wali.dashboard') }}" class="flex items-center px-4 py-3 rounded-xl hover:bg-slate-800 hover:text-white transition group {{ Route::is('wali.dashboard') ? 'bg-primary-500 text-white font-semibold' : '' }}">
                        <i class="fa-solid fa-chart-line w-6"></i>
                        <span x-show="sidebarOpen" class="ml-3">Dashboard</span>
                    </a>
                    <a href="{{ route('wali.siswa') }}" class="flex items-center px-4 py-3 rounded-xl hover:bg-slate-800 hover:text-white transition group {{ Route::is('wali.siswa') ? 'bg-primary-500 text-white font-semibold' : '' }}">
                        <i class="fa-solid fa-user-graduate w-6"></i>
                        <span x-show="sidebarOpen" class="ml-3">Data Siswa</span>
                    </a>
                    <a href="{{ route('wali.jadwal') }}" class="flex items-center px-4 py-3 rounded-xl hover:bg-slate-800 hover:text-white transition group {{ Route::is('wali.jadwal') ? 'bg-primary-500 text-white font-semibold' : '' }}">
                        <i class="fa-solid fa-calendar-days w-6"></i>
                        <span x-show="sidebarOpen" class="ml-3">Jadwal Pelajaran</span>
                    </a>
                    <a href="{{ route('wali.presensi') }}" class="flex items-center px-4 py-3 rounded-xl hover:bg-slate-800 hover:text-white transition group {{ Route::is('wali.presensi') ? 'bg-primary-500 text-white font-semibold' : '' }}">
                        <i class="fa-solid fa-clipboard-user w-6"></i>
                        <span x-show="sidebarOpen" class="ml-3">Presensi Anak</span>
                    </a>
                @endif
            </nav>

            <!-- Bottom User Profile Area -->
            <div class="p-4 border-t border-slate-800 bg-slate-950/40">
                <div class="flex items-center">
                    <div class="shrink-0">
                        @if(Auth::user()->foto)
                            <img class="w-10 h-10 rounded-xl object-cover" src="{{ asset('storage/' . Auth::user()->foto) }}" alt="Avatar">
                        @else
                            <div class="w-10 h-10 rounded-xl bg-slate-800 flex items-center justify-center text-white font-bold">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                    <div class="ml-3" x-show="sidebarOpen">
                        <p class="text-sm font-semibold text-white truncate max-w-[130px]">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-slate-500 capitalize">{{ str_replace('_', ' ', Auth::user()->role) }}</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Workspace -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Navbar Header -->
            <header class="h-16 bg-white border-b border-gray-100 flex items-center justify-between px-6 z-20 shadow-sm shadow-gray-50/20">
                <div class="flex items-center space-x-4">
                    <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 hover:text-gray-700 transition">
                        <i class="fa-solid fa-bars-staggered text-lg"></i>
                    </button>
                    <h2 class="text-sm font-bold text-gray-800 hidden md:block">
                        SMP NEGERI 19 MAKASSAR
                    </h2>
                </div>

                <div class="flex items-center space-x-4">
                    <a href="{{ route('profile.index') }}" class="text-gray-500 hover:text-gray-700 transition px-2 py-1 flex items-center space-x-2">
                        <i class="fa-solid fa-user-gear"></i>
                        <span class="text-sm font-medium">Profil saya</span>
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-red-500 hover:text-red-700 transition flex items-center space-x-1 text-sm font-semibold">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            <span class="hidden sm:inline">Keluar</span>
                        </button>
                    </form>
                </div>
            </header>

            <!-- Main Content Scroll Area -->
            <main class="flex-1 overflow-y-auto p-6 bg-slate-50/50">
                <!-- Breadcrumbs/Page Title -->
                <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-black text-gray-900 tracking-tight">@yield('page_title', 'Sistem Presensi')</h1>
                        <p class="text-sm text-gray-500 mt-1">@yield('page_subtitle', 'Sistem Presensi & Penjadwalan Mata Pelajaran QR Code')</p>
                    </div>
                </div>

                <!-- Session Alert -->
                <div class="max-w-7xl mx-auto">
                    <x-alert />
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <!-- Alert / Toast Script integration via SweetAlert2 -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 3000,
                    customClass: {
                        popup: 'rounded-2xl',
                    }
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: '{{ session('error') }}',
                    confirmButtonColor: '#0ea5e9',
                    customClass: {
                        popup: 'rounded-2xl',
                        confirmButton: 'rounded-xl'
                    }
                });
            @endif
        });
    </script>
    @yield('scripts')
</body>
</html>
