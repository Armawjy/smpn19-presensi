@extends('layouts.app')

@section('title', 'Monitoring Siswa')
@section('page_title', 'Monitoring Siswa')
@section('page_subtitle', 'Pantau kehadiran siswa per kelas secara real-time')

@section('content')
<x-card class="mb-6">
    <form action="{{ route('guru.monitoring') }}" method="GET" class="flex flex-col sm:flex-row gap-4 items-end">
        <!-- Pilih Kelas -->
        <div class="flex-1 w-full">
            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Pilih Kelas</label>
            <select name="kelas_id" onchange="this.form.submit()" class="w-full border-gray-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl text-sm">
                @foreach ($kelas as $k)
                    <option value="{{ $k->id }}" {{ $selectedKelasId == $k->id ? 'selected' : '' }}>
                        Kelas {{ $k->nama_kelas }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Pilih Tanggal -->
        <div class="flex-1 w-full">
            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Pilih Tanggal</label>
            <input type="date" name="tanggal" value="{{ $selectedDate }}" onchange="this.form.submit()" class="w-full border-gray-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl text-sm">
        </div>

        <div class="w-full sm:w-auto">
            <button type="submit" class="w-full bg-primary-500 hover:bg-primary-600 text-white font-bold py-2.5 px-6 rounded-xl transition duration-200 text-sm">
                Refresh
            </button>
        </div>
    </form>
</x-card>

@if ($selectedKelas)
    <h3 class="text-lg font-bold text-gray-800 mb-4">
        Presensi Kelas {{ $selectedKelas->nama_kelas }} - Tanggal {{ $selectedDate }}
    </h3>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse ($siswa as $s)
            @php
                $presensiToday = $s->presensi->first();
            @endphp
            <div class="bg-white rounded-2xl border border-gray-150 p-4 shadow-sm hover:shadow transition relative overflow-hidden flex flex-col items-center">
                <!-- Status accent line -->
                <div class="absolute top-0 inset-x-0 h-1.5 
                    @if($presensiToday)
                        @if($presensiToday->status === 'hadir') bg-green-500
                        @elseif($presensiToday->status === 'izin') bg-blue-500
                        @elseif($presensiToday->status === 'sakit') bg-amber-500
                        @else bg-red-500 @endif
                    @else
                        bg-slate-300
                    @endif">
                </div>

                <!-- Foto Profile -->
                <div class="w-16 h-16 rounded-full overflow-hidden border-2 border-slate-100 shadow-inner mb-3">
                    @if($s->user->foto)
                        <img src="{{ asset('storage/' . $s->user->foto) }}" class="w-full h-full object-cover" alt="Foto">
                    @else
                        <div class="w-full h-full bg-slate-100 flex items-center justify-center font-black text-slate-400 text-xl uppercase">
                            {{ substr($s->user->name, 0, 1) }}
                        </div>
                    @endif
                </div>

                <h4 class="text-sm font-bold text-gray-900 text-center truncate w-full">{{ $s->user->name }}</h4>
                <p class="text-[10px] text-gray-400 font-semibold mt-0.5">NIS. {{ $s->nis }}</p>

                <!-- Status Badge -->
                <div class="mt-4">
                    @if ($presensiToday)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold 
                            @if($presensiToday->status === 'hadir') bg-green-50 text-green-700
                            @elseif($presensiToday->status === 'izin') bg-blue-50 text-blue-700
                            @elseif($presensiToday->status === 'sakit') bg-amber-50 text-amber-700
                            @else bg-red-50 text-red-700 @endif">
                            {{ ucfirst($presensiToday->status) }}
                        </span>
                        <p class="text-[10px] text-gray-400 font-medium text-center mt-2">
                            Masuk: {{ substr($presensiToday->jam_datang, 0, 5) }}
                        </p>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-500">
                            Belum Presensi
                        </span>
                    @endif
                </div>

            </div>
        @empty
            <div class="col-span-full bg-white rounded-2xl border border-gray-150 p-8 text-center text-gray-400 font-medium">
                Belum ada siswa terdaftar di kelas ini.
            </div>
        @endforelse
    </div>
@endif
@endsection
