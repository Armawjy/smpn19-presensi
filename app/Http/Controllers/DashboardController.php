<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Jadwal;
use App\Models\Presensi;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function admin()
    {
        $totalSiswa = Siswa::count();
        $totalGuru = Guru::count();
        $totalKelas = Kelas::count();
        
        $today = Carbon::today()->toDateString();
        $presensiHariIni = Presensi::where('tanggal', $today)->count();

        // Chart.js data: Attendance breakdown for today
        $hadir = Presensi::where('tanggal', $today)->where('status', 'hadir')->count();
        $izin = Presensi::where('tanggal', $today)->where('status', 'izin')->count();
        $sakit = Presensi::where('tanggal', $today)->where('status', 'sakit')->count();
        $alpha = Presensi::where('tanggal', $today)->where('status', 'alpha')->count();

        // Attendance stats for past 7 days
        $pastDays = [];
        $attendanceTrend = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i)->toDateString();
            $pastDays[] = Carbon::today()->subDays($i)->isoFormat('D MMM');
            $attendanceTrend[] = Presensi::where('tanggal', $date)->where('status', 'hadir')->count();
        }

        return view('admin.dashboard', compact(
            'totalSiswa', 'totalGuru', 'totalKelas', 'presensiHariIni',
            'hadir', 'izin', 'sakit', 'alpha',
            'pastDays', 'attendanceTrend'
        ));
    }

    public function guru()
    {
        $user = Auth::user();
        $guru = $user->guru;
        
        if (!$guru) {
            abort(404, 'Guru profile not found.');
        }

        // Hari dalam bahasa Indonesia
        $hariMap = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu',
        ];
        $todayEnglish = Carbon::today()->format('l');
        $hariIni = $hariMap[$todayEnglish] ?? 'Senin';

        // Jadwal mengajar hari ini
        $jadwalHariIni = Jadwal::where('guru_id', $guru->id)
            ->where('hari', $hariIni)
            ->with(['kelas', 'mataPelajaran'])
            ->orderBy('jam_mulai')
            ->get();

        // Total kelas yang diajar
        $totalKelasDiajar = Jadwal::where('guru_id', $guru->id)->distinct('kelas_id')->count('kelas_id');
        
        // Total jadwal mengajar seminggu
        $totalJadwalSeminggu = Jadwal::where('guru_id', $guru->id)->count();

        return view('guru.dashboard', compact('guru', 'jadwalHariIni', 'totalKelasDiajar', 'totalJadwalSeminggu', 'hariIni'));
    }

    public function siswa()
    {
        $user = Auth::user();
        $siswa = $user->siswa;

        if (!$siswa) {
            abort(404, 'Siswa profile not found.');
        }

        $hariMap = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu',
        ];
        $todayEnglish = Carbon::today()->format('l');
        $hariIni = $hariMap[$todayEnglish] ?? 'Senin';

        // Jadwal hari ini
        $jadwalHariIni = Jadwal::where('kelas_id', $siswa->kelas_id)
            ->where('hari', $hariIni)
            ->with(['guru.user', 'mataPelajaran'])
            ->orderBy('jam_mulai')
            ->get();

        // Riwayat presensi 10 terakhir
        $riwayatPresensi = Presensi::where('siswa_id', $siswa->id)
            ->with('jadwal.mataPelajaran')
            ->orderBy('tanggal', 'desc')
            ->orderBy('jam_datang', 'desc')
            ->take(10)
            ->get();

        // Persentase kehadiran
        $totalPresensi = Presensi::where('siswa_id', $siswa->id)->count();
        $hadirCount = Presensi::where('siswa_id', $siswa->id)->where('status', 'hadir')->count();
        $persentaseKehadiran = $totalPresensi > 0 ? round(($hadirCount / $totalPresensi) * 100) : 0;

        return view('siswa.dashboard', compact('siswa', 'jadwalHariIni', 'riwayatPresensi', 'persentaseKehadiran', 'hariIni'));
    }

    public function waliSiswa()
    {
        $user = Auth::user();
        $wali = $user->waliSiswa;

        if (!$wali) {
            abort(404, 'Wali Siswa profile not found.');
        }

        $siswa = $wali->siswa;

        if (!$siswa) {
            return view('wali.dashboard', ['siswa' => null]);
        }

        // Jadwal anak hari ini
        $hariMap = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu',
        ];
        $todayEnglish = Carbon::today()->format('l');
        $hariIni = $hariMap[$todayEnglish] ?? 'Senin';

        $jadwalHariIni = Jadwal::where('kelas_id', $siswa->kelas_id)
            ->where('hari', $hariIni)
            ->with(['guru.user', 'mataPelajaran'])
            ->get();

        // Presensi terakhir anak
        $presensiTerakhir = Presensi::where('siswa_id', $siswa->id)
            ->with('jadwal.mataPelajaran')
            ->orderBy('tanggal', 'desc')
            ->orderBy('jam_datang', 'desc')
            ->take(5)
            ->get();

        return view('wali.dashboard', compact('wali', 'siswa', 'jadwalHariIni', 'presensiTerakhir', 'hariIni'));
    }
}
