@extends('layouts.app')

@section('title', 'Jadwal Mengajar')
@section('page_title', 'Jadwal Mengajar')
@section('page_subtitle', 'Seluruh jadwal mengajar Bapak/Ibu guru dalam seminggu')

@section('content')
<x-card>
    <x-table>
        <x-slot name="thead">
            <th class="px-6 py-4">Hari</th>
            <th class="px-6 py-4">Waktu</th>
            <th class="px-6 py-4">Kelas</th>
            <th class="px-6 py-4">Mata Pelajaran</th>
        </x-slot>

        @forelse ($jadwals as $j)
            <tr class="hover:bg-slate-50/50 transition">
                <td class="px-6 py-4">
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-100">
                        {{ $j->hari }}
                    </span>
                </td>
                <td class="px-6 py-4 font-bold text-gray-800">
                    {{ substr($j->jam_mulai, 0, 5) }} - {{ substr($j->jam_selesai, 0, 5) }}
                </td>
                <td class="px-6 py-4 font-bold text-gray-900">Kelas {{ $j->kelas->nama_kelas }}</td>
                <td class="px-6 py-4 font-semibold text-primary-600">{{ $j->mataPelajaran->nama }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="px-6 py-8 text-center text-gray-400 font-medium">Jadwal mengajar belum tersedia.</td>
            </tr>
        @endforelse
    </x-table>
</x-card>
@endsection
