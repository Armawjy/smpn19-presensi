@extends('layouts.app')

@section('title', 'Data Guru')
@section('page_title', 'Data Guru')
@section('page_subtitle', 'Kelola data tenaga pengajar SMPN 19 Makassar')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div class="flex items-center space-x-2">
        <a href="{{ route('admin.guru.create') }}" class="bg-primary-500 hover:bg-primary-600 text-white font-semibold py-2.5 px-4 rounded-xl transition duration-200 shadow-lg shadow-primary-500/20 text-sm flex items-center">
            <i class="fa-solid fa-plus mr-2"></i> Tambah Guru
        </a>
    </div>
</div>

<x-card>
    <x-table>
        <x-slot name="thead">
            <th class="px-6 py-4">Foto</th>
            <th class="px-6 py-4">NIP</th>
            <th class="px-6 py-4">Nama Lengkap</th>
            <th class="px-6 py-4">Email</th>
            <th class="px-6 py-4">No. HP</th>
            <th class="px-6 py-4 text-center">Aksi</th>
        </x-slot>

        @forelse ($gurus as $g)
            <tr class="hover:bg-slate-50/50 transition">
                <td class="px-6 py-4">
                    @if($g->user->foto)
                        <img src="{{ asset('storage/' . $g->user->foto) }}" class="w-10 h-10 rounded-xl object-cover border" alt="Foto">
                    @else
                        <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-700 font-bold border">
                            {{ strtoupper(substr($g->user->name, 0, 1)) }}
                        </div>
                    @endif
                </td>
                <td class="px-6 py-4 font-semibold text-gray-800">{{ $g->nip }}</td>
                <td class="px-6 py-4 font-semibold text-gray-900">{{ $g->user->name }}</td>
                <td class="px-6 py-4 text-slate-500">{{ $g->user->email }}</td>
                <td class="px-6 py-4 text-slate-500">{{ $g->no_hp ?? '-' }}</td>
                <td class="px-6 py-4 text-center">
                    <div class="flex items-center justify-center space-x-2">
                        <a href="{{ route('admin.guru.show', $g->id) }}" class="p-2 text-indigo-500 hover:bg-indigo-50 rounded-lg transition" title="Detail">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.guru.edit', $g->id) }}" class="p-2 text-amber-500 hover:bg-amber-50 rounded-lg transition" title="Edit">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        <form action="{{ route('admin.guru.destroy', $g->id) }}" method="POST" class="inline delete-form">
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
                <td colspan="6" class="px-6 py-8 text-center text-gray-400 font-medium">Belum ada data guru.</td>
            </tr>
        @endforelse
    </x-table>

    <div class="mt-6">
        {{ $gurus->links() }}
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
                    text: "Data guru dan akun yang bersangkutan akan dihapus permanen!",
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
