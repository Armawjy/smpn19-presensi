@extends('layouts.app')

@section('title', 'Data Anak')
@section('page_title', 'Profil Anak')
@section('page_subtitle', 'Biodata lengkap anak asuh Anda')

@section('content')
<div class="max-w-2xl mx-auto">
    @if(!$siswa)
        <div class="bg-white border rounded-2xl p-6 text-center text-gray-500 font-semibold shadow-sm">
            <p>Data anak belum terhubung.</p>
        </div>
    @else
        <x-card>
            <div class="flex flex-col sm:flex-row items-center sm:items-start space-y-4 sm:space-y-0 sm:space-x-6 pb-6 border-b border-gray-100 mb-6">
                <div class="shrink-0">
                    @if($siswa->user->foto)
                        <img src="{{ asset('storage/' . $siswa->user->foto) }}" class="w-24 h-24 rounded-2xl object-cover border-2 border-primary-500/20 shadow-md" alt="Foto">
                    @else
                        <div class="w-24 h-24 rounded-2xl bg-slate-100 flex items-center justify-center text-slate-400 text-4xl font-extrabold border shadow-inner">
                            {{ strtoupper(substr($siswa->user->name, 0, 1)) }}
                        </div>
                    @endif
                </div>
                <div class="text-center sm:text-left flex-1">
                    <h3 class="text-xl font-black text-gray-900 tracking-tight">{{ $siswa->user->name }}</h3>
                    <p class="text-sm text-slate-500 mt-1">NIS. {{ $siswa->nis }}</p>
                    <div class="mt-3 flex flex-wrap gap-2 justify-center sm:justify-start">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-primary-50 text-primary-700">
                            Kelas: {{ $siswa->kelas->nama_kelas }}
                        </span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700">
                            Status: Aktif Siswa
                        </span>
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                <h4 class="text-sm font-bold text-gray-400 uppercase tracking-wider">Biodata Siswa</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-slate-50 p-4 rounded-xl border border-gray-100">
                    <div>
                        <p class="text-xs text-gray-400 font-semibold">Agama</p>
                        <p class="text-sm font-bold text-gray-800 mt-0.5">{{ $siswa->agama ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-semibold">No. HP Siswa</p>
                        <p class="text-sm font-bold text-gray-800 mt-0.5">{{ $siswa->no_hp ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-semibold">Wali Kelas</p>
                        <p class="text-sm font-bold text-gray-800 mt-0.5">{{ $siswa->kelas->waliKelas->user->name ?? 'Belum Ditugaskan' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-semibold">Jenis Kelamin</p>
                        <p class="text-sm font-bold text-gray-800 mt-0.5">{{ $siswa->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-xs text-gray-400 font-semibold">Alamat Tempat Tinggal</p>
                        <p class="text-sm font-bold text-gray-800 mt-0.5">{{ $siswa->alamat ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </x-card>
    @endif
</div>
@endsection
