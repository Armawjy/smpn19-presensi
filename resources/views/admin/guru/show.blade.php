@extends('layouts.app')

@section('title', 'Detail Guru')
@section('page_title', 'Detail Guru')
@section('page_subtitle', 'Biodata lengkap tenaga pengajar')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-4">
        <a href="{{ route('admin.guru.index') }}" class="text-gray-500 hover:text-gray-700 transition flex items-center text-sm font-semibold">
            <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Daftar
        </a>
    </div>

    <x-card>
        <div class="flex flex-col sm:flex-row items-center sm:items-start space-y-4 sm:space-y-0 sm:space-x-6 pb-6 border-b border-gray-100 mb-6">
            <div class="shrink-0">
                @if($guru->user->foto)
                    <img src="{{ asset('storage/' . $guru->user->foto) }}" class="w-24 h-24 rounded-2xl object-cover border-2 border-primary-500/20 shadow-md" alt="Foto">
                @else
                    <div class="w-24 h-24 rounded-2xl bg-slate-100 flex items-center justify-center text-slate-400 text-4xl font-extrabold border shadow-inner">
                        {{ strtoupper(substr($guru->user->name, 0, 1)) }}
                    </div>
                @endif
            </div>
            <div class="text-center sm:text-left">
                <h3 class="text-xl font-black text-gray-900 tracking-tight">{{ $guru->user->name }}</h3>
                <p class="text-sm text-slate-500 mt-1">NIP. {{ $guru->nip }}</p>
                <div class="mt-3 flex flex-wrap gap-2 justify-center sm:justify-start">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-primary-50 text-primary-700">
                        Guru / Pengajar
                    </span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $guru->jenis_kelamin === 'L' ? 'bg-sky-50 text-sky-700' : 'bg-pink-50 text-pink-700' }}">
                        {{ $guru->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}
                    </span>
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <h4 class="text-sm font-bold text-gray-400 uppercase tracking-wider">Informasi Kontak & Alamat</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-slate-50 p-4 rounded-xl border border-gray-100">
                <div>
                    <p class="text-xs text-gray-400 font-semibold">Alamat Email</p>
                    <p class="text-sm font-bold text-gray-800 mt-0.5">{{ $guru->user->email }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 font-semibold">No. HP (Whatsapp)</p>
                    <p class="text-sm font-bold text-gray-800 mt-0.5">{{ $guru->no_hp ?? '-' }}</p>
                </div>
                <div class="md:col-span-2">
                    <p class="text-xs text-gray-400 font-semibold">Alamat Tempat Tinggal</p>
                    <p class="text-sm font-bold text-gray-800 mt-0.5">{{ $guru->alamat ?? '-' }}</p>
                </div>
            </div>

            <!-- Kelas yang Diajar -->
            <div class="pt-4">
                <h4 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-2">Kelas yang Wali & Jadwal Ajar</h4>
                <div class="space-y-2">
                    @php
                        $waliKelas = \App\Models\Kelas::where('wali_kelas_id', $guru->id)->get();
                    @endphp
                    @if($waliKelas->isNotEmpty())
                        <div class="p-3 bg-emerald-50 text-emerald-800 border border-emerald-100 rounded-xl text-xs font-semibold flex items-center">
                            <i class="fa-solid fa-certificate mr-2"></i> Wali Kelas: {{ $waliKelas->pluck('nama_kelas')->join(', ') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="mt-6 pt-6 border-t border-gray-100 flex justify-end">
            <a href="{{ route('admin.guru.edit', $guru->id) }}" class="bg-primary-500 hover:bg-primary-600 text-white font-bold py-2 px-4 rounded-xl transition duration-200 text-sm flex items-center">
                <i class="fa-solid fa-pen-to-square mr-2"></i> Edit Data
            </a>
        </div>
    </x-card>
</div>
@endsection
