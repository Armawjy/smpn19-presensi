@extends('layouts.app')

@section('title', 'Riwayat Presensi')
@section('page_title', 'Riwayat Presensi')
@section('page_subtitle', 'Seluruh riwayat catatan kehadiran Anda')

@section('content')
<x-card>
    <x-table>
        <x-slot name="thead">
            <th class="px-6 py-4">Tanggal</th>
            <th class="px-6 py-4">Mata Pelajaran</th>
            <th class="px-6 py-4">Jam Masuk</th>
            <th class="px-6 py-4">Jam Pulang</th>
            <th class="px-6 py-4 text-center">Status</th>
            <th class="px-6 py-4">Keterangan</th>
        </x-slot>

        @forelse ($presensis as $p)
            <tr class="hover:bg-slate-50/50 transition">
                <td class="px-6 py-4 font-bold text-gray-800">{{ $p->tanggal }}</td>
                <td class="px-6 py-4 font-bold text-primary-600">{{ $p->jadwal->mataPelajaran->nama ?? '-' }}</td>
                <td class="px-6 py-4 text-emerald-600 font-bold">{{ $p->jam_datang ? substr($p->jam_datang, 0, 5) : '-' }}</td>
                <td class="px-6 py-4 text-blue-600 font-bold">
                    @if($p->jam_pulang)
                        {{ substr($p->jam_pulang, 0, 5) }}
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
                <td class="px-6 py-4 text-slate-500 text-xs">{{ $p->keterangan ?? '-' }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="px-6 py-8 text-center text-gray-400 font-medium">Belum ada riwayat kehadiran dicatat.</td>
            </tr>
        @endforelse
    </x-table>

    <div class="mt-6">
        {{ $presensis->links() }}
    </div>
</x-card>
@endsection
