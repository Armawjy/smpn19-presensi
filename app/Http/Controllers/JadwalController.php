<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\Guru;
use App\Models\MataPelajaran;
use Illuminate\Support\Facades\Auth;

class JadwalController extends Controller
{
    public function index(Request $request)
    {
        $query = Jadwal::with(['kelas', 'guru.user', 'mataPelajaran']);

        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        $jadwals = $query->orderBy('hari')->orderBy('jam_mulai')->paginate(15);
        $kelas = Kelas::where('status', 'aktif')->get();

        return view('admin.jadwal.index', compact('jadwals', 'kelas'));
    }

    public function create()
    {
        $kelas = Kelas::where('status', 'aktif')->get();
        $gurus = Guru::with('user')->get();
        $mapels = MataPelajaran::where('status', 'aktif')->get();
        
        return view('admin.jadwal.create', compact('kelas', 'gurus', 'mapels'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'guru_id' => 'required|exists:guru,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
        ]);

        Jadwal::create($request->all());

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function edit(Jadwal $jadwal)
    {
        $kelas = Kelas::where('status', 'aktif')->get();
        $gurus = Guru::with('user')->get();
        $mapels = MataPelajaran::where('status', 'aktif')->get();

        return view('admin.jadwal.edit', compact('jadwal', 'kelas', 'gurus', 'mapels'));
    }

    public function update(Request $request, Jadwal $jadwal)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'guru_id' => 'required|exists:guru,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
        ]);

        $jadwal->update($request->all());

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil diubah.');
    }

    public function destroy(Jadwal $jadwal)
    {
        $jadwal->delete();
        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil dihapus.');
    }

    public function jadwalPerKelas($kelasId)
    {
        $kelas = Kelas::findOrFail($kelasId);
        $jadwals = Jadwal::where('kelas_id', $kelasId)
            ->with(['guru.user', 'mataPelajaran'])
            ->orderBy('hari')
            ->orderBy('jam_mulai')
            ->get();

        return view('admin.jadwal.kelas', compact('kelas', 'jadwals'));
    }

    // Role-specific schedules
    public function guruJadwal()
    {
        $guru = Auth::user()->guru;
        $jadwals = Jadwal::where('guru_id', $guru->id)
            ->with(['kelas', 'mataPelajaran'])
            ->orderBy('hari')
            ->orderBy('jam_mulai')
            ->get();

        return view('guru.jadwal', compact('jadwals'));
    }

    public function siswaJadwal()
    {
        $siswa = Auth::user()->siswa;
        $jadwals = Jadwal::where('kelas_id', $siswa->kelas_id)
            ->with(['guru.user', 'mataPelajaran'])
            ->orderBy('hari')
            ->orderBy('jam_mulai')
            ->get();

        return view('siswa.jadwal', compact('jadwals'));
    }

    public function waliJadwal()
    {
        $wali = Auth::user()->waliSiswa;
        $siswa = $wali->siswa;
        $jadwals = [];
        if ($siswa) {
            $jadwals = Jadwal::where('kelas_id', $siswa->kelas_id)
                ->with(['guru.user', 'mataPelajaran'])
                ->orderBy('hari')
                ->orderBy('jam_mulai')
                ->get();
        }

        return view('wali.jadwal', compact('jadwals', 'siswa'));
    }
}
