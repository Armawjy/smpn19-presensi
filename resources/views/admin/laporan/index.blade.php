@extends('layouts.app')

@section('title', 'Laporan Kehadiran Siswa')
@section('page_title', 'Laporan Presensi')
@section('page_subtitle', 'Filter dan export rekap kehadiran siswa')

@section('content')
<x-card class="mb-6">
    <form action="{{ route('admin.laporan.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
        
        <!-- Kelas Filter -->
        <div>
            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Pilih Kelas</label>
            <select name="kelas_id" class="w-full border-gray-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl text-sm">
                <option value="">Semua Kelas</option>
                @foreach ($kelas as $k)
                    <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>
                        Kelas {{ $k->nama_kelas }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Tanggal Mulai -->
        <div>
            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Tanggal Mulai</label>
            <input type="date" name="tanggal_mulai" value="{{ request('tanggal_mulai', date('Y-m-d')) }}" class="w-full border-gray-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl text-sm">
        </div>

        <!-- Tanggal Selesai -->
        <div>
            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Tanggal Selesai</label>
            <input type="date" name="tanggal_selesai" value="{{ request('tanggal_selesai', date('Y-m-d')) }}" class="w-full border-gray-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl text-sm">
        </div>

        <!-- Filter Button -->
        <div class="flex space-x-2">
            <button type="submit" class="flex-1 bg-primary-500 hover:bg-primary-600 text-white font-bold py-2.5 px-4 rounded-xl transition duration-200 text-sm">
                Filter Data
            </button>
            <a href="{{ route('admin.laporan.index') }}" class="bg-gray-100 hover:bg-gray-200 border text-gray-800 font-bold py-2.5 px-4 rounded-xl transition duration-200 text-sm">
                Reset
            </a>
        </div>
    </form>
</x-card>

<div class="mt-8 mb-6 flex flex-wrap gap-2.5 justify-end">
    <!-- Export PDF -->
    <a href="{{ route('admin.laporan.pdf', request()->all()) }}" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2.5 px-4 rounded-xl transition duration-200 text-sm flex items-center shadow-lg shadow-red-500/20">
        <i class="fa-solid fa-file-pdf mr-2"></i> Export ke PDF
    </a>

    <!-- Export Excel -->
    <a href="{{ route('admin.laporan.excel', request()->all()) }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2.5 px-4 rounded-xl transition duration-200 text-sm flex items-center shadow-lg shadow-green-500/20">
        <i class="fa-solid fa-file-excel mr-2"></i> Export ke Excel
    </a>
</div>

<x-card>
    <x-table>
        <x-slot name="thead">
            <th class="px-6 py-4">Tanggal</th>
            <th class="px-6 py-4">Nama Siswa</th>
            <th class="px-6 py-4">Kelas</th>
            <th class="px-6 py-4">Mata Pelajaran</th>
            <th class="px-6 py-4">Jam Datang</th>
            <th class="px-6 py-4">Jam Pulang</th>
            <th class="px-6 py-4 text-center">Status</th>
        </x-slot>

        @forelse ($presensis as $p)
            <tr class="hover:bg-slate-50/50 transition">
                <td class="px-6 py-4 font-bold text-gray-800">{{ $p->tanggal }}</td>
                <td class="px-6 py-4 font-semibold text-gray-900">{{ $p->siswa->user->name }}</td>
                <td class="px-6 py-4 text-gray-700">Kelas {{ $p->siswa->kelas->nama_kelas }}</td>
                <td class="px-6 py-4 text-primary-600 font-semibold">{{ $p->jadwal->mataPelajaran->nama ?? '-' }}</td>
                <td class="px-6 py-4 text-emerald-600 font-bold">{{ $p->jam_datang ? substr($p->jam_datang, 0, 5) : '-' }}</td>
                <td class="px-6 py-4 text-blue-600 font-bold">{{ $p->jam_pulang ? substr($p->jam_pulang, 0, 5) : '-' }}</td>
                <td class="px-6 py-4 text-center">
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold 
                        @if($p->status === 'hadir') bg-green-50 text-green-700
                        @elseif($p->status === 'izin') bg-blue-50 text-blue-700
                        @elseif($p->status === 'sakit') bg-amber-50 text-amber-700
                        @else bg-red-50 text-red-700 @endif">
                        {{ ucfirst($p->status) }}
                    </span>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="px-6 py-8 text-center text-gray-400 font-medium">Tidak ada data kehadiran yang ditemukan.</td>
            </tr>
        @endforelse
    </x-table>
</x-card>
@endsection
