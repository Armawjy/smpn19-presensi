@extends('layouts.app')

@section('title', 'Tambah Wali Siswa')
@section('page_title', 'Tambah Wali Siswa')
@section('page_subtitle', 'Hubungkan siswa dengan wali penanggung jawab')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-4">
        <a href="{{ route('admin.wali-siswa.index') }}" class="text-gray-500 hover:text-gray-700 transition flex items-center text-sm font-semibold">
            <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Daftar
        </a>
    </div>

    <x-card>
        <form action="{{ route('admin.wali-siswa.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama Lengkap -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap Wali</label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="w-full border-gray-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl text-sm" placeholder="Contoh: H. Muhammad Arifin, S.E.">
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Email Wali</label>
                    <input type="email" name="email" value="{{ old('email') }}" required class="w-full border-gray-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl text-sm" placeholder="wali@gmail.com">
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Password Akun</label>
                    <input type="password" name="password" required class="w-full border-gray-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl text-sm" placeholder="••••••••">
                </div>

                <!-- Hubungan -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Hubungan dengan Siswa</label>
                    <select name="hubungan" required class="w-full border-gray-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl text-sm">
                        <option value="">Pilih Hubungan</option>
                        <option value="Ayah" {{ old('hubungan') === 'Ayah' ? 'selected' : '' }}>Ayah</option>
                        <option value="Ibu" {{ old('hubungan') === 'Ibu' ? 'selected' : '' }}>Ibu</option>
                        <option value="Wali" {{ old('hubungan') === 'Wali' ? 'selected' : '' }}>Wali / Saudara</option>
                    </select>
                </div>

                <!-- Pilih Siswa -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Pilih Siswa Asuhan</label>
                    <select name="siswa_id" required class="w-full border-gray-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl text-sm">
                        <option value="">Cari dan Pilih Siswa</option>
                        @foreach ($siswas as $s)
                            <option value="{{ $s->id }}" {{ old('siswa_id') == $s->id ? 'selected' : '' }}>
                                {{ $s->user->name }} (NIS. {{ $s->nis }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- No. HP -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">No. HP (Whatsapp)</label>
                    <input type="text" name="no_hp" value="{{ old('no_hp') }}" class="w-full border-gray-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl text-sm" placeholder="08XXXXXXXXXX">
                </div>
            </div>

            <div class="pt-4 border-t border-gray-100 flex justify-end space-x-2">
                <a href="{{ route('admin.wali-siswa.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-bold py-2.5 px-5 rounded-xl transition duration-200 text-sm">Batal</a>
                <x-button>Simpan Data Wali</x-button>
            </div>
        </form>
    </x-card>
</div>
@endsection
