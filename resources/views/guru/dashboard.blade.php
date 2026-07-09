@extends('layouts.app')

@section('title', 'Guru Dashboard')
@section('page_title', 'Dashboard Guru')
@section('page_subtitle', 'Selamat datang kembali, Bapak/Ibu Guru')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <x-card>
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Jadwal Mengajar Hari Ini</p>
                <h3 class="text-3xl font-black text-slate-850 mt-1">{{ $jadwalHariIni->count() }}</h3>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-500 flex items-center justify-center text-xl shadow-inner border border-indigo-100">
                <i class="fa-solid fa-calendar-day"></i>
            </div>
        </div>
    </x-card>

    <x-card>
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Kelas Diajar</p>
                <h3 class="text-3xl font-black text-slate-850 mt-1">{{ $totalKelasDiajar }}</h3>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-sky-50 text-sky-500 flex items-center justify-center text-xl shadow-inner border border-sky-100">
                <i class="fa-solid fa-school"></i>
            </div>
        </div>
    </x-card>

    <x-card>
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Jam Ajar Seminggu</p>
                <h3 class="text-3xl font-black text-slate-850 mt-1">{{ $totalJadwalSeminggu }}</h3>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-500 flex items-center justify-center text-xl shadow-inner border border-emerald-100">
                <i class="fa-solid fa-hourglass-half"></i>
            </div>
        </div>
    </x-card>
</div>

<!-- Jadwal Pelajaran Hari Ini -->
<x-card>
    <x-slot name="title">Jadwal Mengajar Hari Ini ({{ $hariIni }})</x-slot>
    <x-table>
        <x-slot name="thead">
            <th class="px-6 py-4">Waktu</th>
            <th class="px-6 py-4">Kelas</th>
            <th class="px-6 py-4">Mata Pelajaran</th>
            <th class="px-6 py-4 text-center">Aksi</th>
        </x-slot>

        @forelse ($jadwalHariIni as $j)
            <tr class="hover:bg-slate-50/50 transition">
                <td class="px-6 py-4 font-bold text-slate-800">
                    <i class="fa-regular fa-clock mr-1.5 text-gray-400"></i> {{ substr($j->jam_mulai, 0, 5) }} - {{ substr($j->jam_selesai, 0, 5) }}
                </td>
                <td class="px-6 py-4 font-bold text-gray-950">Kelas {{ $j->kelas->nama_kelas }}</td>
                <td class="px-6 py-4 font-semibold text-primary-600">{{ $j->mataPelajaran->nama }}</td>
                <td class="px-6 py-4 text-center">
                    <a href="{{ route('guru.scan') }}" class="inline-flex items-center px-3 py-1.5 bg-primary-50 text-primary-700 hover:bg-primary-100 rounded-xl transition text-xs font-bold border border-primary-200">
                        <i class="fa-solid fa-camera mr-1"></i> Mulai Scan Presensi
                    </a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="px-6 py-8 text-center text-gray-400 font-medium">Tidak ada jadwal mengajar hari ini.</td>
            </tr>
        @endforelse
    </x-table>
</x-card>
@endsection
