@extends('layouts.app')

@section('title', 'Daftar QR Code Siswa')
@section('page_title', 'QR Code Siswa')
@section('page_subtitle', 'Cetak atau unduh kartu identitas QR Code siswa')

@section('content')
<x-card>
    <x-table>
        <x-slot name="thead">
            <th class="px-6 py-4">Nama Siswa</th>
            <th class="px-6 py-4">NIS</th>
            <th class="px-6 py-4">Kelas</th>
            <th class="px-6 py-4 text-center">QR Code Code</th>
            <th class="px-6 py-4 text-center">Preview</th>
            <th class="px-6 py-4 text-center">Aksi</th>
        </x-slot>

        @forelse ($siswas as $s)
            @php
                $qrCodeText = $s->qr_code ?? ('SMPN19-' . $s->nis);
            @endphp
            <tr class="hover:bg-slate-50/50 transition">
                <td class="px-6 py-4 font-bold text-gray-900">{{ $s->user->name }}</td>
                <td class="px-6 py-4 text-gray-700 font-semibold">{{ $s->nis }}</td>
                <td class="px-6 py-4 text-gray-650">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">
                        Kelas {{ $s->kelas->nama_kelas }}
                    </span>
                </td>
                <td class="px-6 py-4 text-center text-xs font-mono font-bold text-sky-650">{{ $qrCodeText }}</td>
                <td class="px-6 py-4 flex justify-center">
                    <div class="p-1 bg-white border rounded-lg shadow-sm">
                        {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(50)->generate($qrCodeText) !!}
                    </div>
                </td>
                <td class="px-6 py-4 text-center">
                    <div class="flex items-center justify-center space-x-2">
                        <a href="{{ route('admin.qr-code.cetak', $s->id) }}" target="_blank" class="px-3 py-1.5 bg-emerald-50 text-emerald-600 hover:bg-emerald-100 rounded-xl transition text-xs font-bold flex items-center border border-emerald-100">
                            <i class="fa-solid fa-print mr-1"></i> Cetak Kartu
                        </a>
                        <a href="{{ route('admin.qr-code.download', $s->id) }}" class="px-3 py-1.5 bg-sky-50 text-sky-600 hover:bg-sky-100 rounded-xl transition text-xs font-bold flex items-center border border-sky-100">
                            <i class="fa-solid fa-download mr-1"></i> Unduh SVG
                        </a>
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
        {{ $siswas->links() }}
    </div>
</x-card>
@endsection
