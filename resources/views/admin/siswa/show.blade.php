@extends('layouts.app')

@section('title', 'Detail Siswa')
@section('page_title', 'Detail Siswa')
@section('page_subtitle', 'Biodata lengkap siswa beserta detail pendukung')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-4">
        <a href="{{ route('admin.siswa.index') }}" class="text-gray-500 hover:text-gray-700 transition flex items-center text-sm font-semibold">
            <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Daftar
        </a>
    </div>

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
                        Status: Aktif
                    </span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $siswa->jenis_kelamin === 'L' ? 'bg-sky-50 text-sky-700' : 'bg-pink-50 text-pink-700' }}">
                        {{ $siswa->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}
                    </span>
                </div>
            </div>

            <!-- QR Code section -->
            <div class="flex flex-col items-center p-3 bg-slate-50 rounded-2xl border border-gray-100">
                @if($siswa->qr_code)
                    <div class="p-2 bg-white rounded-xl shadow-sm border border-gray-100">
                        {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(80)->generate($siswa->qr_code) !!}
                    </div>
                    <span class="text-[10px] font-bold text-gray-500 mt-1.5">{{ $siswa->qr_code }}</span>
                @else
                    <div class="w-20 h-20 bg-gray-100 rounded-xl flex items-center justify-center text-gray-400">
                        <i class="fa-solid fa-qrcode text-2xl"></i>
                    </div>
                @endif
            </div>
        </div>

        <div class="space-y-6">
            <div>
                <h4 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-2.5">Detail Biodata</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-slate-50 p-4 rounded-xl border border-gray-100">
                    <div>
                        <p class="text-xs text-gray-400 font-semibold">Agama</p>
                        <p class="text-sm font-bold text-gray-800 mt-0.5">{{ $siswa->agama ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-semibold">No. HP</p>
                        <p class="text-sm font-bold text-gray-800 mt-0.5">{{ $siswa->no_hp ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-semibold">Akun Email</p>
                        <p class="text-sm font-bold text-gray-800 mt-0.5">{{ $siswa->user->email }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-semibold">Wali Kelas</p>
                        <p class="text-sm font-bold text-gray-800 mt-0.5">{{ $siswa->kelas->waliKelas->user->name ?? 'Belum Ditugaskan' }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-xs text-gray-400 font-semibold">Alamat Tempat Tinggal</p>
                        <p class="text-sm font-bold text-gray-800 mt-0.5">{{ $siswa->alamat ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Wali Siswa Linked -->
            <div>
                <h4 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-2.5">Wali Siswa (Orang Tua)</h4>
                @if($siswa->waliSiswa)
                    <div class="p-4 bg-primary-50/50 border border-primary-100 rounded-xl flex items-center justify-between">
                        <div>
                            <p class="text-sm font-bold text-gray-900">{{ $siswa->waliSiswa->user->name }}</p>
                            <p class="text-xs text-slate-500 mt-0.5">{{ $siswa->waliSiswa->hubungan }} • Telp. {{ $siswa->waliSiswa->no_hp ?? '-' }}</p>
                        </div>
                        <span class="text-xs font-bold text-primary-600 bg-white border border-primary-200 px-3 py-1 rounded-lg">Linked</span>
                    </div>
                @else
                    <div class="p-4 bg-amber-50 border border-amber-100 text-amber-800 rounded-xl text-xs font-semibold flex items-center">
                        <i class="fa-solid fa-triangle-exclamation mr-2"></i> Belum ada wali siswa yang terhubung.
                    </div>
                @endif
            </div>
        </div>

        <div class="mt-6 pt-6 border-t border-gray-100 flex justify-end space-x-2">
            @if($siswa->qr_code)
                <a href="{{ route('admin.qr-code.cetak', $siswa->id) }}" target="_blank" class="bg-gray-100 hover:bg-gray-200 text-gray-850 font-bold py-2 px-4 rounded-xl transition duration-200 text-sm flex items-center border border-gray-200">
                    <i class="fa-solid fa-print mr-2"></i> Cetak Kartu QR
                </a>
            @endif
            <a href="{{ route('admin.siswa.edit', $siswa->id) }}" class="bg-primary-500 hover:bg-primary-600 text-white font-bold py-2 px-4 rounded-xl transition duration-200 text-sm flex items-center">
                <i class="fa-solid fa-pen-to-square mr-2"></i> Edit Data
            </a>
        </div>
    </x-card>
</div>
@endsection
