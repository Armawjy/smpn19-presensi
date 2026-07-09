@extends('layouts.app')

@section('title', 'Tambah Jadwal Baru')
@section('page_title', 'Tambah Jadwal')
@section('page_subtitle', 'Tautkan Kelas, Mata Pelajaran, Guru dan Waktu Belajar')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-4">
        <a href="{{ route('admin.jadwal.index') }}" class="text-gray-500 hover:text-gray-700 transition flex items-center text-sm font-semibold">
            <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Daftar
        </a>
    </div>

    <x-card>
        <form action="{{ route('admin.jadwal.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Kelas -->
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Pilih Kelas</label>
                <select name="kelas_id" required class="w-full border-gray-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl text-sm">
                    <option value="">Pilih Kelas</option>
                    @foreach ($kelas as $k)
                        <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>
                            {{ $k->nama_kelas }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Mata Pelajaran -->
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Pilih Mata Pelajaran</label>
                <select name="mata_pelajaran_id" required class="w-full border-gray-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl text-sm">
                    <option value="">Pilih Mata Pelajaran</option>
                    @foreach ($mapels as $m)
                        <option value="{{ $m->id }}" {{ old('mata_pelajaran_id') == $m->id ? 'selected' : '' }}>
                            {{ $m->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Guru Pengajar -->
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Guru Pengajar</label>
                <select name="guru_id" required class="w-full border-gray-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl text-sm">
                    <option value="">Pilih Guru Pengajar</option>
                    @foreach ($gurus as $g)
                        <option value="{{ $g->id }}" {{ old('guru_id') == $g->id ? 'selected' : '' }}>
                            {{ $g->user->name }} (NIP. {{ $g->nip }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Hari -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Hari</label>
                    <select name="hari" required class="w-full border-gray-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl text-sm">
                        <option value="">Pilih Hari</option>
                        @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $day)
                            <option value="{{ $day }}" {{ old('hari') === $day ? 'selected' : '' }}>
                                {{ $day }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Jam Mulai -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Jam Mulai</label>
                    <input type="time" name="jam_mulai" value="{{ old('jam_mulai', '07:30') }}" required class="w-full border-gray-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl text-sm">
                </div>

                <!-- Jam Selesai -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Jam Selesai</label>
                    <input type="time" name="jam_selesai" value="{{ old('jam_selesai', '09:00') }}" required class="w-full border-gray-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl text-sm">
                </div>
            </div>

            <div class="pt-4 border-t border-gray-100 flex justify-end space-x-2">
                <a href="{{ route('admin.jadwal.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-bold py-2.5 px-5 rounded-xl transition duration-200 text-sm">Batal</a>
                <x-button>Simpan Jadwal</x-button>
            </div>
        </form>
    </x-card>
</div>
@endsection
