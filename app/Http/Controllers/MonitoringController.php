<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Presensi;
use App\Models\Jadwal;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class MonitoringController extends Controller
{
    public function index(Request $request)
    {
        $guru = Auth::user()->guru;
        // Cari kelas-kelas yang diajar oleh guru ini
        $kelasIds = Jadwal::where('guru_id', $guru->id)->distinct()->pluck('kelas_id');
        $kelas = Kelas::whereIn('id', $kelasIds)->get();

        $selectedKelasId = $request->kelas_id ?? $kelasIds->first();
        $selectedDate = $request->tanggal ?? Carbon::today()->toDateString();

        $siswa = [];
        $selectedKelas = null;

        if ($selectedKelasId) {
            $selectedKelas = Kelas::find($selectedKelasId);
            $siswa = Siswa::where('kelas_id', $selectedKelasId)
                ->with(['user', 'presensi' => function ($q) use ($selectedDate) {
                    $q->where('tanggal', $selectedDate);
                }])->get();
        }

        return view('guru.monitoring', compact('kelas', 'siswa', 'selectedKelasId', 'selectedDate', 'selectedKelas'));
    }

    public function status(Request $request)
    {
        // Mendapatkan persentase kehadiran per kelas yang diajar guru
        $guru = Auth::user()->guru;
        $kelasIds = Jadwal::where('guru_id', $guru->id)->distinct()->pluck('kelas_id');
        $kelas = Kelas::whereIn('id', $kelasIds)->get();

        $stats = [];
        foreach ($kelas as $k) {
            $totalSiswa = Siswa::where('kelas_id', $k->id)->count();
            $hadirHariIni = Presensi::where('tanggal', Carbon::today()->toDateString())
                ->whereHas('siswa', function ($q) use ($k) {
                    $q->where('kelas_id', $k->id);
                })->where('status', 'hadir')->count();

            $stats[] = [
                'kelas' => $k->nama_kelas,
                'total_siswa' => $totalSiswa,
                'hadir_hari_ini' => $hadirHariIni,
                'persentase' => $totalSiswa > 0 ? round(($hadirHariIni / $totalSiswa) * 100) : 0,
            ];
        }

        return view('guru.status-monitoring', compact('stats'));
    }
}
