@extends('layouts.app')

@section('title', 'Siswa Dashboard')
@section('page_title', 'Dashboard Siswa')
@section('page_subtitle', 'Tinjau jadwal dan riwayat kehadiran Anda')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <!-- Welcome card -->
    <x-card>
        <div class="flex items-center space-x-4">
            <div class="w-16 h-16 rounded-2xl bg-primary-50 text-primary-500 flex items-center justify-center text-2xl border">
                <i class="fa-solid fa-graduation-cap"></i>
            </div>
            <div>
                <h3 class="text-lg font-bold text-gray-900">{{ $siswa->user->name }}</h3>
                <p class="text-xs text-gray-500">NIS. {{ $siswa->nis }} • Kelas {{ $siswa->kelas->nama_kelas }}</p>
            </div>
        </div>
    </x-card>

    <!-- Persentase Kehadiran -->
    <x-card>
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Persentase Kehadiran</p>
                <h3 class="text-3xl font-black text-slate-850 mt-1">{{ $persentaseKehadiran }}%</h3>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-550 flex items-center justify-center text-xl border">
                <i class="fa-solid fa-square-poll-vertical"></i>
            </div>
        </div>
    </x-card>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Jadwal Pelajaran Hari Ini -->
    <div class="bg-white rounded-2xl border border-gray-150 p-6 lg:col-span-1 shadow-sm">
        <h3 class="text-base font-bold text-gray-800 mb-4 border-b pb-2 flex items-center">
            <i class="fa-solid fa-calendar-day text-primary-500 mr-2"></i> Pelajaran Hari Ini ({{ $hariIni }})
        </h3>
        <ul class="space-y-3.5">
            @forelse ($jadwalHariIni as $j)
                <li class="flex items-start space-x-3 p-3 bg-slate-50 rounded-xl border border-gray-100">
                    <div class="shrink-0 text-slate-400 text-xs font-bold mt-0.5">
                        <i class="fa-regular fa-clock"></i>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-700">{{ substr($j->jam_mulai, 0, 5) }} - {{ substr($j->jam_selesai, 0, 5) }}</p>
                        <p class="text-sm font-extrabold text-gray-900 mt-0.5">{{ $j->mataPelajaran->nama }}</p>
                        <p class="text-[10px] text-gray-400 font-semibold">Guru: {{ $j->guru->user->name }}</p>
                    </div>
                </li>
            @empty
                <li class="text-center text-gray-400 font-medium text-sm py-6">Tidak ada jadwal hari ini.</li>
            @endforelse
        </ul>
    </div>

    <!-- Riwayat Presensi Terakhir -->
    <div class="bg-white rounded-2xl border border-gray-150 p-6 lg:col-span-2 shadow-sm">
        <h3 class="text-base font-bold text-gray-800 mb-4 border-b pb-2 flex items-center">
            <i class="fa-solid fa-clock-rotate-left text-primary-500 mr-2"></i> Kehadiran Terakhir
        </h3>
        <x-table>
            <x-slot name="thead">
                <th class="px-4 py-3">Tanggal</th>
                <th class="px-4 py-3">Mata Pelajaran</th>
                <th class="px-4 py-3">Jam Masuk</th>
                <th class="px-4 py-3 text-center">Status</th>
            </x-slot>

            @forelse ($riwayatPresensi as $p)
                <tr class="hover:bg-slate-50/50 transition text-xs">
                    <td class="px-4 py-3 font-semibold text-gray-800">{{ $p->tanggal }}</td>
                    <td class="px-4 py-3 font-bold text-primary-600">{{ $p->jadwal->mataPelajaran->nama ?? '-' }}</td>
                    <td class="px-4 py-3 font-semibold text-emerald-600">{{ $p->jam_datang ? substr($p->jam_datang, 0, 5) : '-' }}</td>
                    <td class="px-4 py-3 text-center">
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold 
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
                    <td colspan="4" class="px-4 py-6 text-center text-gray-400">Belum ada riwayat kehadiran.</td>
                </tr>
            @endforelse
        </x-table>
    </div>
</div>
@endsection
