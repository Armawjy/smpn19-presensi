@extends('layouts.app')

@section('title', 'Jadwal Pelajaran')
@section('page_title', 'Jadwal Pelajaran')
@section('page_subtitle', 'Manajemen kalender jadwal belajar mengajar')

@section('content')
<div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
        <a href="{{ route('admin.jadwal.create') }}" class="bg-primary-500 hover:bg-primary-600 text-white font-semibold py-2.5 px-4 rounded-xl transition duration-200 shadow-lg shadow-primary-500/20 text-sm flex items-center">
            <i class="fa-solid fa-plus mr-2"></i> Tambah Jadwal Baru
        </a>
    </div>

    <!-- Filter Kelas -->
    <form action="{{ route('admin.jadwal.index') }}" method="GET" class="flex items-center gap-2">
        <select name="kelas_id" onchange="this.form.submit()" class="border-gray-200 focus:border-primary-500 focus:ring-primary-500 rounded-xl text-sm">
            <option value="">Semua Kelas</option>
            @foreach ($kelas as $k)
                <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>
                    Kelas {{ $k->nama_kelas }}
                </option>
            @endforeach
        </select>
        <button type="submit" class="bg-gray-100 hover:bg-gray-200 border border-gray-200 text-gray-850 px-4 py-2.5 rounded-xl text-sm font-semibold transition duration-200">
            Filter
        </button>
    </form>
</div>

<x-card>
    <x-table>
        <x-slot name="thead">
            <th class="px-6 py-4">Hari</th>
            <th class="px-6 py-4">Kelas</th>
            <th class="px-6 py-4">Mata Pelajaran</th>
            <th class="px-6 py-4">Guru</th>
            <th class="px-6 py-4">Jam Belajar</th>
            <th class="px-6 py-4 text-center">Aksi</th>
        </x-slot>

        @forelse ($jadwals as $j)
            <tr class="hover:bg-slate-50/50 transition">
                <td class="px-6 py-4 font-bold text-slate-800">
                    <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-bold bg-slate-100 text-slate-700">
                        {{ $j->hari }}
                    </span>
                </td>
                <td class="px-6 py-4 font-bold text-gray-950">{{ $j->kelas->nama_kelas }}</td>
                <td class="px-6 py-4 font-semibold text-primary-600">{{ $j->mataPelajaran->nama }}</td>
                <td class="px-6 py-4 font-medium text-gray-700">{{ $j->guru->user->name }}</td>
                <td class="px-6 py-4 font-bold text-slate-650">
                    <i class="fa-regular fa-clock mr-1.5 text-gray-400"></i> {{ substr($j->jam_mulai, 0, 5) }} - {{ substr($j->jam_selesai, 0, 5) }}
                </td>
                <td class="px-6 py-4 text-center">
                    <div class="flex items-center justify-center space-x-2">
                        <a href="{{ route('admin.jadwal.edit', $j->id) }}" class="p-2 text-amber-500 hover:bg-amber-50 rounded-lg transition" title="Edit">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        <form action="{{ route('admin.jadwal.destroy', $j->id) }}" method="POST" class="inline delete-form">
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
                <td colspan="6" class="px-6 py-8 text-center text-gray-400 font-medium">Belum ada data jadwal pelajaran.</td>
            </tr>
        @endforelse
    </x-table>

    <div class="mt-6">
        {{ $jadwals->appends(request()->input())->links() }}
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
                    text: "Jadwal ini akan dihapus secara permanen dari sistem!",
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
