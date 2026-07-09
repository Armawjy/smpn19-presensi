@extends('layouts.app')

@section('title', 'Data Wali Siswa')
@section('page_title', 'Wali Siswa')
@section('page_subtitle', 'Hubungkan dan kelola data orang tua / wali siswa')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <a href="{{ route('admin.wali-siswa.create') }}" class="bg-primary-500 hover:bg-primary-600 text-white font-semibold py-2.5 px-4 rounded-xl transition duration-200 shadow-lg shadow-primary-500/20 text-sm flex items-center">
            <i class="fa-solid fa-plus mr-2"></i> Tambah Wali Siswa
        </a>
    </div>
</div>

<x-card>
    <x-table>
        <x-slot name="thead">
            <th class="px-6 py-4">Nama Wali</th>
            <th class="px-6 py-4">Email Wali</th>
            <th class="px-6 py-4">Siswa Hubungan</th>
            <th class="px-6 py-4">Hubungan</th>
            <th class="px-6 py-4">No. HP</th>
            <th class="px-6 py-4 text-center">Aksi</th>
        </x-slot>

        @forelse ($walis as $w)
            <tr class="hover:bg-slate-50/50 transition">
                <td class="px-6 py-4 font-semibold text-gray-900">{{ $w->user->name }}</td>
                <td class="px-6 py-4 text-slate-500">{{ $w->user->email }}</td>
                <td class="px-6 py-4 font-semibold text-primary-600">
                    {{ $w->siswa->user->name ?? 'N/A' }} 
                    <span class="text-xs text-gray-400">({{ $w->siswa->nis ?? '-' }})</span>
                </td>
                <td class="px-6 py-4">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-700">
                        {{ $w->hubungan }}
                    </span>
                </td>
                <td class="px-6 py-4 text-slate-500">{{ $w->no_hp ?? '-' }}</td>
                <td class="px-6 py-4 text-center">
                    <div class="flex items-center justify-center space-x-2">
                        <a href="{{ route('admin.wali-siswa.edit', $w->id) }}" class="p-2 text-amber-500 hover:bg-amber-50 rounded-lg transition" title="Edit">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        <form action="{{ route('admin.wali-siswa.destroy', $w->id) }}" method="POST" class="inline delete-form">
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
                <td colspan="6" class="px-6 py-8 text-center text-gray-400 font-medium">Belum ada data wali siswa.</td>
            </tr>
        @endforelse
    </x-table>

    <div class="mt-6">
        {{ $walis->links() }}
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
                    text: "Data wali dan hubungannya akan dihapus dari sistem!",
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
