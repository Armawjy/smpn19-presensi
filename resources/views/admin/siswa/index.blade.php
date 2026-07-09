@extends('layouts.app')

@section('title', 'Data Siswa')
@section('page_title', 'Data Siswa')
@section('page_subtitle', 'Kelola data siswa SMPN 19 Makassar')

@section('content')
<div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <!-- Action buttons -->
    <div>
        <a href="{{ route('admin.siswa.create') }}" class="bg-primary-500 hover:bg-primary-600 text-white font-semibold py-2.5 px-4 rounded-xl transition duration-200 shadow-lg shadow-primary-500/20 text-sm flex items-center">
            <i class="fa-solid fa-plus mr-2"></i> Tambah Siswa
        </a>
    </div>

    <!-- Filter and Search -->
    <form action="{{ route('admin.siswa.index') }}" method="GET" class="flex flex-col sm:flex-row gap-2.5 items-stretch sm:items-center">
        <!-- Class Filter -->
        <select name="kelas_id" onchange="this.form.submit()" class="border-gray-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl text-sm">
            <option value="">Semua Kelas</option>
            @foreach ($kelas as $k)
                <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>
                    {{ $k->nama_kelas }}
                </option>
            @endforeach
        </select>

        <!-- Search input -->
        <div class="relative flex-1">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                <i class="fa-solid fa-magnifying-glass"></i>
            </span>
            <input 
                type="text" 
                name="search" 
                value="{{ request('search') }}"
                placeholder="Cari NIS atau nama..." 
                class="border-gray-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl pl-9 text-sm w-full min-w-[200px]"
            >
        </div>

        <button type="submit" class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold py-2.5 px-4 rounded-xl transition duration-200 border border-gray-200 text-sm">
            Cari
        </button>
    </form>
</div>

<x-card>
    <x-table>
        <x-slot name="thead">
            <th class="px-6 py-4">Foto</th>
            <th class="px-6 py-4">NIS</th>
            <th class="px-6 py-4">Nama Siswa</th>
            <th class="px-6 py-4">Kelas</th>
            <th class="px-6 py-4">QR Code</th>
            <th class="px-6 py-4 text-center">Aksi</th>
        </x-slot>

        @forelse ($siswas as $s)
            <tr class="hover:bg-slate-50/50 transition">
                <td class="px-6 py-4">
                    @if($s->user->foto)
                        <img src="{{ asset('storage/' . $s->user->foto) }}" class="w-10 h-10 rounded-xl object-cover border" alt="Foto">
                    @else
                        <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-700 font-bold border">
                            {{ strtoupper(substr($s->user->name, 0, 1)) }}
                        </div>
                    @endif
                </td>
                <td class="px-6 py-4 font-semibold text-gray-800">{{ $s->nis }}</td>
                <td class="px-6 py-4 font-semibold text-gray-900">{{ $s->user->name }}</td>
                <td class="px-6 py-4 font-semibold text-slate-600">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-800">
                        {{ $s->kelas->nama_kelas }}
                    </span>
                </td>
                <td class="px-6 py-4 text-slate-500">
                    @if($s->qr_code)
                        <span class="inline-flex items-center text-emerald-600 font-bold text-xs bg-emerald-50 px-2 py-1 rounded-lg">
                            <i class="fa-solid fa-qrcode mr-1.5"></i> {{ $s->qr_code }}
                        </span>
                    @else
                        <form action="{{ route('admin.siswa.generate-qr', $s->id) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-xs text-primary-500 hover:underline font-bold">
                                Generate QR Code
                            </button>
                        </form>
                    @endif
                </td>
                <td class="px-6 py-4 text-center">
                    <div class="flex items-center justify-center space-x-2">
                        <a href="{{ route('admin.siswa.show', $s->id) }}" class="p-2 text-indigo-500 hover:bg-indigo-50 rounded-lg transition" title="Detail">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.siswa.edit', $s->id) }}" class="p-2 text-amber-500 hover:bg-amber-50 rounded-lg transition" title="Edit">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        <form action="{{ route('admin.siswa.destroy', $s->id) }}" method="POST" class="inline delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition btn-delete" title="Hapus">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="px-6 py-8 text-center text-gray-400 font-medium">Belum ada data siswa.</td>
            </tr>
        @endforelse
    </x-table>

    <div class="mt-6">
        {{ $siswas->appends(request()->input())->links() }}
    </div>
</x-card>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const deleteButtons = document.querySelectorAll('.btn-delete');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                const form = this.closest('.delete-form');
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data siswa dan akun yang bersangkutan akan dihapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal',
                    customClass: {
                        popup: 'rounded-2xl',
                        confirmButton: 'rounded-xl px-4 py-2 font-bold text-sm',
                        cancelButton: 'rounded-xl px-4 py-2 font-bold text-sm'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>
@endsection
