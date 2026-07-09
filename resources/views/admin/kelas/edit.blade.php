@extends('layouts.app')

@section('title', 'Edit Kelas')
@section('page_title', 'Edit Kelas')
@section('page_subtitle', 'Modifikasi rombel kelas dan wali kelas')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-4">
        <a href="{{ route('admin.kelas.index') }}" class="text-gray-500 hover:text-gray-700 transition flex items-center text-sm font-semibold">
            <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Daftar
        </a>
    </div>

    <x-card>
        <form action="{{ route('admin.kelas.update', $kelas->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Nama Kelas -->
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Nama Kelas</label>
                <input type="text" name="nama_kelas" value="{{ old('nama_kelas', $kelas->nama_kelas) }}" required class="w-full border-gray-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl text-sm">
            </div>

            <!-- Wali Kelas -->
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Tetapkan Wali Kelas</label>
                <select name="wali_kelas_id" class="w-full border-gray-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl text-sm">
                    <option value="">Pilih Wali Kelas (Bisa dikosongkan)</option>
                    @foreach ($gurus as $g)
                        <option value="{{ $g->id }}" {{ old('wali_kelas_id', $kelas->wali_kelas_id) == $g->id ? 'selected' : '' }}>
                            {{ $g->user->name }} (NIP. {{ $g->nip }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Deskripsi -->
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Deskripsi Kelas</label>
                <textarea name="deskripsi" rows="3" class="w-full border-gray-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl text-sm">{{ old('deskripsi', $kelas->deskripsi) }}</textarea>
            </div>

            <!-- Status -->
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Status Kelas</label>
                <select name="status" required class="w-full border-gray-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl text-sm">
                    <option value="aktif" {{ old('status', $kelas->status) === 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ old('status', $kelas->status) === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>

            <div class="pt-4 border-t border-gray-100 flex justify-end space-x-2">
                <a href="{{ route('admin.kelas.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-bold py-2.5 px-5 rounded-xl transition duration-200 text-sm">Batal</a>
                <x-button>Simpan Perubahan</x-button>
            </div>
        </form>
    </x-card>
</div>
@endsection
