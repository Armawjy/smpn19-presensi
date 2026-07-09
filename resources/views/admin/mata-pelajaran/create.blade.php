@extends('layouts.app')

@section('title', 'Tambah Mata Pelajaran')
@section('page_title', 'Tambah Mata Pelajaran')
@section('page_subtitle', 'Masukkan detail mata pelajaran baru')

@section('content')
<div class="max-w-xl mx-auto">
    <div class="mb-4">
        <a href="{{ route('admin.mata-pelajaran.index') }}" class="text-gray-500 hover:text-gray-700 transition flex items-center text-sm font-semibold">
            <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Daftar
        </a>
    </div>

    <x-card>
        <form action="{{ route('admin.mata-pelajaran.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Nama Mapel -->
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Nama Mata Pelajaran</label>
                <input type="text" name="nama" value="{{ old('nama') }}" required class="w-full border-gray-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl text-sm" placeholder="Contoh: Matematika, IPA, Seni Budaya">
            </div>

            <!-- Deskripsi -->
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Deskripsi Pelajaran (Opsional)</label>
                <textarea name="deskripsi" rows="3" class="w-full border-gray-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl text-sm" placeholder="Tulis deskripsi atau catatan pelajaran disini...">{{ old('deskripsi') }}</textarea>
            </div>

            <!-- Status -->
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Status Pelajaran</label>
                <select name="status" required class="w-full border-gray-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl text-sm">
                    <option value="aktif" {{ old('status') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ old('status') === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>

            <div class="pt-4 border-t border-gray-100 flex justify-end space-x-2">
                <a href="{{ route('admin.mata-pelajaran.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-bold py-2.5 px-5 rounded-xl transition duration-200 text-sm">Batal</a>
                <x-button>Simpan Pelajaran</x-button>
            </div>
        </form>
    </x-card>
</div>
@endsection
