@extends('layouts.app')

@section('title', 'Presensi Siswa')
@section('page_title', 'Presensi Siswa')
@section('page_subtitle', 'Rekap kehadiran siswa yang berada di kelas Anda')

@section('content')
<div class="mb-6 flex">
    <a href="{{ route('guru.scan') }}" class="bg-primary-500 hover:bg-primary-600 text-white font-semibold py-2.5 px-4 rounded-xl transition duration-200 shadow-lg shadow-primary-500/20 text-sm flex items-center">
        <i class="fa-solid fa-camera mr-2"></i> Buka Kamera Scanner
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
                <td class="px-6 py-4 font-bold text-slate-800">
                    <span class="inline-flex items-center text-emerald-600 bg-emerald-50 px-2 py-1 rounded-lg text-xs">
                        {{ $p->jam_datang ? substr($p->jam_datang, 0, 5) : '-' }}
                    </span>
                </td>
                <td class="px-6 py-4 font-bold text-slate-800">
                    @if($p->jam_pulang)
                        <span class="inline-flex items-center text-blue-600 bg-blue-50 px-2 py-1 rounded-lg text-xs">
                            {{ substr($p->jam_pulang, 0, 5) }}
                        </span>
                    @else
                        <span class="text-xs text-gray-450 italic">Belum Pulang</span>
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
            </tr>
        @empty
            <tr>
                <td colspan="7" class="px-6 py-8 text-center text-gray-400 font-medium">Belum ada catatan presensi siswa.</td>
            </tr>
        @endforelse
    </x-table>

    <div class="mt-6">
        {{ $presensis->links() }}
    </div>
</x-card>
@endsection
