<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Presensi;
use App\Models\Siswa;
use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\LaporanPresensiExport;
use Maatwebsite\Excel\Facades\Excel;

class PresensiController extends Controller
{
    public function index(Request $request)
    {
        $kelas = Kelas::where('status', 'aktif')->get();
        $query = Presensi::with(['siswa.user', 'siswa.kelas', 'jadwal.mataPelajaran']);

        if ($request->filled('kelas_id')) {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('kelas_id', $request->kelas_id);
            });
        }

        if ($request->filled('tanggal')) {
            $query->where('tanggal', $request->tanggal);
        } else {
            $query->where('tanggal', Carbon::today()->toDateString());
        }

        $presensis = $query->paginate(15);

        return view('admin.presensi.index', compact('presensis', 'kelas'));
    }

    public function scan()
    {
        // Render scanning page
        return view('admin.presensi.scan');
    }

    public function prosesScan(Request $request)
    {
        $request->validate([
            'qr_code' => 'required|string',
        ]);

        $qrCodeText = $request->qr_code;
        // Format expected: SMPN19-{NIS} or just NIS
        $nis = str_replace('SMPN19-', '', $qrCodeText);

        $siswa = Siswa::where('nis', $nis)->with('user')->first();

        if (!$siswa) {
            return response()->json([
                'success' => false,
                'message' => 'Siswa dengan NIS ' . $nis . ' tidak ditemukan.'
            ], 404);
        }

        // Cari jadwal kelas siswa hari ini
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
        $todayDate = Carbon::today()->toDateString();

        $jadwal = Jadwal::where('kelas_id', $siswa->kelas_id)
            ->where('hari', $hariIni)
            ->first();

        if (!$jadwal) {
            // Jika tidak ada jadwal hari ini, coba cari jadwal default/pertama kelas tersebut untuk testing
            $jadwal = Jadwal::where('kelas_id', $siswa->kelas_id)->first();
            if (!$jadwal) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada jadwal pelajaran untuk kelas siswa hari ini.'
                ], 400);
            }
        }

        // Check existing attendance for today and this schedule
        $presensi = Presensi::where('siswa_id', $siswa->id)
            ->where('jadwal_id', $jadwal->id)
            ->where('tanggal', $todayDate)
            ->first();

        $nowTime = Carbon::now()->toTimeString();

        if (!$presensi) {
            // Presensi Datang
            $presensi = Presensi::create([
                'siswa_id' => $siswa->id,
                'jadwal_id' => $jadwal->id,
                'tanggal' => $todayDate,
                'jam_datang' => $nowTime,
                'status' => 'hadir',
                'keterangan' => 'Hadir via Scan QR Code',
            ]);

            return response()->json([
                'success' => true,
                'type' => 'datang',
                'name' => $siswa->user->name,
                'nis' => $siswa->nis,
                'time' => $nowTime,
                'message' => 'Presensi DATANG Berhasil: ' . $siswa->user->name
            ]);
        } else {
            // Presensi Pulang
            if ($presensi->jam_pulang) {
                return response()->json([
                    'success' => false,
                    'message' => 'Siswa ' . $siswa->user->name . ' sudah melakukan presensi datang dan pulang hari ini.'
                ], 400);
            }

            $presensi->update([
                'jam_pulang' => $nowTime,
            ]);

            return response()->json([
                'success' => true,
                'type' => 'pulang',
                'name' => $siswa->user->name,
                'nis' => $siswa->nis,
                'time' => $nowTime,
                'message' => 'Presensi PULANG Berhasil: ' . $siswa->user->name
            ]);
        }
    }

    public function presensiDatang(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'jadwal_id' => 'required|exists:jadwal,id',
            'tanggal' => 'required|date',
            'status' => 'required|in:hadir,izin,sakit,alpha',
            'keterangan' => 'nullable|string',
        ]);

        Presensi::create([
            'siswa_id' => $request->siswa_id,
            'jadwal_id' => $request->jadwal_id,
            'tanggal' => $request->tanggal,
            'jam_datang' => Carbon::now()->toTimeString(),
            'status' => $request->status,
            'keterangan' => $request->keterangan,
        ]);

        return back()->with('success', 'Presensi datang berhasil dicatat.');
    }

    public function presensiPulang(Request $request, Presensi $presensi)
    {
        $presensi->update([
            'jam_pulang' => Carbon::now()->toTimeString(),
        ]);

        return back()->with('success', 'Presensi pulang berhasil dicatat.');
    }

    // Laporan & Export
    public function laporan(Request $request)
    {
        $kelas = Kelas::where('status', 'aktif')->get();
        $query = Presensi::with(['siswa.user', 'siswa.kelas', 'jadwal.mataPelajaran']);

        if ($request->filled('kelas_id')) {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('kelas_id', $request->kelas_id);
            });
        }

        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) {
            $query->whereBetween('tanggal', [$request->tanggal_mulai, $request->tanggal_selesai]);
        }

        $presensis = $query->orderBy('tanggal', 'desc')->get();

        return view('admin.laporan.index', compact('presensis', 'kelas'));
    }

    public function exportPDF(Request $request)
    {
        $query = Presensi::with(['siswa.user', 'siswa.kelas', 'jadwal.mataPelajaran']);

        if ($request->filled('kelas_id')) {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('kelas_id', $request->kelas_id);
            });
        }

        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) {
            $query->whereBetween('tanggal', [$request->tanggal_mulai, $request->tanggal_selesai]);
        }

        $presensis = $query->orderBy('tanggal', 'desc')->get();

        $pdf = Pdf::loadView('admin.laporan.pdf', compact('presensis'));
        return $pdf->download('laporan_presensi_' . date('Y-m-d') . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        $query = Presensi::with(['siswa.user', 'siswa.kelas', 'jadwal.mataPelajaran']);

        if ($request->filled('kelas_id')) {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('kelas_id', $request->kelas_id);
            });
        }

        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) {
            $query->whereBetween('tanggal', [$request->tanggal_mulai, $request->tanggal_selesai]);
        }

        $presensis = $query->orderBy('tanggal', 'desc')->get();

        return Excel::download(new LaporanPresensiExport($presensis), 'laporan_presensi_' . date('Y-m-d') . '.xlsx');
    }

    // Role specific attendance views
    public function guruPresensi()
    {
        $guru = Auth::user()->guru;
        $kelasIds = Jadwal::where('guru_id', $guru->id)->distinct()->pluck('kelas_id');
        
        $presensis = Presensi::whereHas('siswa', function ($q) use ($kelasIds) {
            $q->whereIn('kelas_id', $kelasIds);
        })->with(['siswa.user', 'siswa.kelas', 'jadwal.mataPelajaran'])
          ->orderBy('tanggal', 'desc')
          ->paginate(15);

        return view('guru.presensi', compact('presensis'));
    }

    public function siswaPresensi()
    {
        $siswa = Auth::user()->siswa;
        $presensis = Presensi::where('siswa_id', $siswa->id)
            ->with(['jadwal.mataPelajaran'])
            ->orderBy('tanggal', 'desc')
            ->paginate(15);

        return view('siswa.presensi', compact('presensis'));
    }

    public function waliPresensi()
    {
        $wali = Auth::user()->waliSiswa;
        $siswa = $wali->siswa;
        $presensis = [];
        if ($siswa) {
            $presensis = Presensi::where('siswa_id', $siswa->id)
                ->with(['jadwal.mataPelajaran'])
                ->orderBy('tanggal', 'desc')
                ->paginate(15);
        }

        return view('wali.presensi', compact('presensis', 'siswa'));
    }
}
