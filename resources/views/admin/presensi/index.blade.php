@extends('layouts.app')

@section('title', 'Data Presensi Siswa')
@section('page_title', 'Data Presensi')
@section('page_subtitle', 'Daftar kehadiran siswa hari ini')

@section('content')
<div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
        <a href="{{ route('admin.presensi.scan') }}" class="bg-primary-500 hover:bg-primary-600 text-white font-semibold py-2.5 px-4 rounded-xl transition duration-200 shadow-lg shadow-primary-500/20 text-sm flex items-center">
            <i class="fa-solid fa-camera mr-2"></i> Buka Kamera Scanner
        </a>
    </div>

    <!-- Filters -->
    <form action="{{ route('admin.presensi.index') }}" method="GET" class="flex flex-col sm:flex-row gap-2.5 items-stretch sm:items-center">
        <!-- Date filter -->
        <input 
            type="date" 
            name="tanggal" 
            value="{{ request('tanggal', date('Y-m-d')) }}" 
            onchange="this.form.submit()"
            class="border-gray-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl text-sm"
        >

        <!-- Class Filter -->
        <select name="kelas_id" onchange="this.form.submit()" class="border-gray-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl text-sm">
            <option value="">Semua Kelas</option>
            @foreach ($kelas as $k)
                <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>
                    Kelas {{ $k->nama_kelas }}
                </option>
            @endforeach
        </select>

        <button type="submit" class="bg-gray-100 hover:bg-gray-200 text-gray-850 font-semibold py-2.5 px-4 rounded-xl border border-gray-200 text-sm transition">
            Filter
        </button>
    </form>
</div>

<x-card>
    <x-table>
        <x-slot name="thead">
            <th class="px-6 py-4">Nama Siswa</th>
            <th class="px-6 py-4">NIS</th>
            <th class="px-6 py-4">Kelas</th>
            <th class="px-6 py-4">Mata Pelajaran</th>
            <th class="px-6 py-4">Jam Datang</th>
            <th class="px-6 py-4">Jam Pulang</th>
            <th class="px-6 py-4 text-center">Status</th>
            <th class="px-6 py-4">Keterangan</th>
        </x-slot>

        @forelse ($presensis as $p)
            <tr class="hover:bg-slate-50/50 transition">
                <td class="px-6 py-4 font-bold text-gray-900">{{ $p->siswa->user->name }}</td>
                <td class="px-6 py-4 font-semibold text-slate-700">{{ $p->siswa->nis }}</td>
                <td class="px-6 py-4 text-gray-700">Kelas {{ $p->siswa->kelas->nama_kelas }}</td>
                <td class="px-6 py-4 font-medium text-primary-600">{{ $p->jadwal->mataPelajaran->nama ?? '-' }}</td>
                <td class="px-6 py-4 font-bold text-slate-800">
                    <span class="inline-flex items-center text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-lg text-xs">
                        <i class="fa-regular fa-clock mr-1"></i> {{ $p->jam_datang ? substr($p->jam_datang, 0, 5) : '-' }}
                    </span>
                </td>
                <td class="px-6 py-4 font-bold text-slate-800">
                    @if($p->jam_pulang)
                        <span class="inline-flex items-center text-blue-600 bg-blue-50 px-2.5 py-1 rounded-lg text-xs">
                            <i class="fa-regular fa-clock mr-1"></i> {{ substr($p->jam_pulang, 0, 5) }}
                        </span>
                    @else
                        <span class="text-xs text-gray-400 italic">Belum Pulang</span>
                    @endif
                </td>
                <td class="px-6 py-4 text-center">
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold 
                        @if($p->status === 'hadir') bg-green-50 text-green-700
                        @elseif($p->status === 'izin') bg-blue-50 text-blue-700
                        @elseif($p->status === 'sakit') bg-amber-50 text-amber-700
                        @else bg-red-50 text-red-700 @endif">
                        {{ ucfirst($p->status) }}
                    </span>
                </td>
                <td class="px-6 py-4 text-slate-500 text-xs truncate max-w-[150px]">{{ $p->keterangan ?? '-' }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="px-6 py-8 text-center text-gray-400 font-medium">Tidak ada data kehadiran untuk filter yang dipilih.</td>
            </tr>
        @endforelse
    </x-table>

    <div class="mt-6">
        {{ $presensis->appends(request()->input())->links() }}
    </div>
</x-card>
@endsection
