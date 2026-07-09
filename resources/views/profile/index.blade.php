@extends('layouts.app')

@section('title', 'Profil Saya')
@section('page_title', 'Profil Pengguna')
@section('page_subtitle', 'Kelola informasi pribadi dan pengaturan keamanan akun Anda')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    
    <!-- User summary card -->
    <div class="lg:col-span-1 space-y-6">
        <x-card>
            <div class="flex flex-col items-center text-center">
                <!-- Profile photo -->
                <div class="relative w-28 h-28 rounded-full border-4 border-white shadow-lg overflow-hidden bg-slate-100 mb-4">
                    @if(Auth::user()->foto)
                        <img src="{{ asset('storage/' . Auth::user()->foto) }}" class="w-full h-full object-cover" alt="Avatar">
                    @else
                        <div class="w-full h-full flex items-center justify-center font-black text-slate-400 text-3xl">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                    @endif
                </div>

                <h3 class="text-lg font-bold text-gray-900">{{ Auth::user()->name }}</h3>
                <p class="text-xs text-sky-600 font-bold uppercase tracking-wider mt-1 bg-sky-50 border border-sky-100 px-3 py-1 rounded-full">
                    {{ str_replace('_', ' ', Auth::user()->role) }}
                </p>
                
                <div class="w-full border-t border-slate-100 my-4"></div>

                <div class="text-left w-full space-y-2">
                    <p class="text-xs text-slate-400 font-semibold uppercase tracking-wider">Email Terdaftar</p>
                    <p class="text-sm font-bold text-gray-800 truncate">{{ Auth::user()->email }}</p>
                </div>
            </div>
        </x-card>
    </div>

    <!-- Edit Profile forms -->
    <div class="lg:col-span-2 space-y-6">
        
        <!-- Update details -->
        <x-card>
            <x-slot name="title">Perbarui Informasi Profil</x-slot>
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" required class="w-full border-gray-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Alamat Email</label>
                        <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" required class="w-full border-gray-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl text-sm">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Unggah Foto Profil Baru</label>
                    <input type="file" name="foto" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                </div>

                <div class="pt-4 border-t flex justify-end">
                    <x-button>Simpan Profil</x-button>
                </div>
            </form>
        </x-card>

        <!-- Change Password -->
        <x-card>
            <x-slot name="title">Keamanan Sandi Akun</x-slot>
            <form action="{{ route('profile.password') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Password Saat Ini</label>
                    <input type="password" name="current_password" required class="w-full border-gray-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl text-sm" placeholder="••••••••">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Password Baru</label>
                        <input type="password" name="password" required class="w-full border-gray-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl text-sm" placeholder="••••••••">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" required class="w-full border-gray-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl text-sm" placeholder="••••••••">
                    </div>
                </div>

                <div class="pt-4 border-t flex justify-end">
                    <x-button variant="danger">Ganti Password</x-button>
                </div>
            </form>
        </x-card>
    </div>

</div>
@endsection
