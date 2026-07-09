@extends('layouts.app')

@section('title', 'Laporan Presensi')
@section('page_title', 'Laporan Presensi')
@section('page_subtitle', 'Tinjau riwayat kehadiran siswa untuk kelas Anda')

@section('content')
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
                <td colspan="7" class="px-6 py-8 text-center text-gray-400 font-medium">Tidak ada data presensi pelajaran.</td>
            </tr>
        @endforelse
    </x-table>
</x-card>
@endsection
