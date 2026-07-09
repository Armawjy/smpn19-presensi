<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Guru;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::with('waliKelas.user')->paginate(10);
        $gurus = Guru::with('user')->get();
        return view('admin.kelas.index', compact('kelas', 'gurus'));
    }

    public function create()
    {
        $gurus = Guru::with('user')->get();
        return view('admin.kelas.create', compact('gurus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|string|unique:kelas|max:50',
            'deskripsi' => 'nullable|string',
            'wali_kelas_id' => 'nullable|exists:guru,id',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        Kelas::create($request->all());

        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function edit(Kelas $kela)
    {
        $gurus = Guru::with('user')->get();
        return view('admin.kelas.edit', ['kelas' => $kela, 'gurus' => $gurus]);
    }

    public function update(Request $request, Kelas $kela)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:50|unique:kelas,nama_kelas,' . $kela->id,
            'deskripsi' => 'nullable|string',
            'wali_kelas_id' => 'nullable|exists:guru,id',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $kela->update($request->all());

        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil diperbarui.');
    }

    public function destroy(Kelas $kela)
    {
        $kela->delete();
        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil dihapus.');
    }

    public function assignWaliKelas(Request $request, Kelas $kela)
    {
        $request->validate([
            'wali_kelas_id' => 'required|exists:guru,id',
        ]);

        $kela->update(['wali_kelas_id' => $request->wali_kelas_id]);

        return back()->with('success', 'Wali Kelas berhasil ditugaskan.');
    }
}
