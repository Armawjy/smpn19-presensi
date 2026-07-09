@extends('layouts.app')

@section('title', 'Tambah Siswa')
@section('page_title', 'Tambah Siswa')
@section('page_subtitle', 'Masukkan biodata lengkap siswa baru')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-4">
        <a href="{{ route('admin.siswa.index') }}" class="text-gray-500 hover:text-gray-700 transition flex items-center text-sm font-semibold">
            <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Daftar
        </a>
    </div>

    <x-card>
        <form action="{{ route('admin.siswa.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- NIS -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">NIS (Nomor Induk Siswa)</label>
                    <input type="text" name="nis" value="{{ old('nis') }}" required class="w-full border-gray-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl text-sm" placeholder="Contoh: 2023001">
                </div>

                <!-- Nama Lengkap -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap Siswa</label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="w-full border-gray-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl text-sm" placeholder="Contoh: Andi Muhammad Fauzan">
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Email Akun</label>
                    <input type="email" name="email" value="{{ old('email') }}" required class="w-full border-gray-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl text-sm" placeholder="siswa@gmail.com">
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Password Akun</label>
                    <input type="password" name="password" required class="w-full border-gray-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl text-sm" placeholder="••••••••">
                </div>

                <!-- Kelas -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Pilih Kelas</label>
                    <select name="kelas_id" required class="w-full border-gray-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl text-sm">
                        <option value="">Pilih Kelas Siswa</option>
                        @foreach ($kelas as $k)
                            <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>
                                {{ $k->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Jenis Kelamin -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Jenis Kelamin</label>
                    <select name="jenis_kelamin" required class="w-full border-gray-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl text-sm">
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="L" {{ old('jenis_kelamin') === 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin') === 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <!-- Agama -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Agama</label>
                    <input type="text" name="agama" value="{{ old('agama', 'Islam') }}" class="w-full border-gray-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl text-sm" placeholder="Contoh: Islam">
                </div>

                <!-- No. HP -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">No. HP Siswa / Wali</label>
                    <input type="text" name="no_hp" value="{{ old('no_hp') }}" class="w-full border-gray-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl text-sm" placeholder="08XXXXXXXXXX">
                </div>
            </div>

            <!-- Alamat -->
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Alamat Lengkap</label>
                <textarea name="alamat" rows="3" class="w-full border-gray-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl text-sm" placeholder="Alamat lengkap siswa...">{{ old('alamat') }}</textarea>
            </div>

            <!-- Upload Foto -->
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Foto Profil Siswa (Opsional)</label>
                <input type="file" name="foto" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                <p class="text-xs text-gray-400 mt-1">Format: JPG, PNG. Ukuran maks: 2MB.</p>
            </div>

            <div class="pt-4 border-t border-gray-100 flex justify-end space-x-2">
                <a href="{{ route('admin.siswa.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-bold py-2.5 px-5 rounded-xl transition duration-200 text-sm">Batal</a>
                <x-button>Simpan Data Siswa</x-button>
            </div>
        </form>
    </x-card>
</div>
@endsection
