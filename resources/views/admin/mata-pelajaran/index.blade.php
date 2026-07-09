@extends('layouts.app')

@section('title', 'Mata Pelajaran')
@section('page_title', 'Mata Pelajaran')
@section('page_subtitle', 'Manajemen daftar mata pelajaran SMPN 19 Makassar')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <a href="{{ route('admin.mata-pelajaran.create') }}" class="bg-primary-500 hover:bg-primary-600 text-white font-semibold py-2.5 px-4 rounded-xl transition duration-200 shadow-lg shadow-primary-500/20 text-sm flex items-center">
            <i class="fa-solid fa-plus mr-2"></i> Tambah Pelajaran
        </a>
    </div>
</div>

<x-card>
    <x-table>
        <x-slot name="thead">
            <th class="px-6 py-4">Nama Pelajaran</th>
            <th class="px-6 py-4">Deskripsi</th>
            <th class="px-6 py-4 text-center">Status</th>
            <th class="px-6 py-4 text-center">Aksi</th>
        </x-slot>

        @forelse ($mapels as $m)
            <tr class="hover:bg-slate-50/50 transition">
                <td class="px-6 py-4 font-bold text-gray-900">{{ $m->nama }}</td>
                <td class="px-6 py-4 text-slate-500 text-xs">{{ $m->deskripsi ?? '-' }}</td>
                <td class="px-6 py-4 text-center">
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold {{ $m->status === 'aktif' ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700' }}">
                        {{ ucfirst($m->status) }}
                    </span>
                </td>
                <td class="px-6 py-4 text-center">
                    <div class="flex items-center justify-center space-x-2">
                        <a href="{{ route('admin.mata-pelajaran.edit', $m->id) }}" class="p-2 text-amber-500 hover:bg-amber-50 rounded-lg transition" title="Edit">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        <form action="{{ route('admin.mata-pelajaran.destroy', $m->id) }}" method="POST" class="inline delete-form">
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
                <td colspan="4" class="px-6 py-8 text-center text-gray-400 font-medium">Belum ada data mata pelajaran.</td>
            </tr>
        @endforelse
    </x-table>

    <div class="mt-6">
        {{ $mapels->links() }}
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
                    text: "Seluruh jadwal pelajaran yang berkaitan akan dihapus permanen!",
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
