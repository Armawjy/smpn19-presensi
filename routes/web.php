<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\WaliSiswaController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\MataPelajaranController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\QRCodeController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
    
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

// Auth Routes (All Logged In Users)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // User Profiles
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // ==========================================
    // ADMIN ROUTES
    // ==========================================
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');

        // CRUDs
        Route::resource('guru', GuruController::class);
        Route::resource('siswa', SiswaController::class);
        Route::post('siswa/{siswa}/generate-qr', [SiswaController::class, 'generateQR'])->name('siswa.generate-qr');
        
        Route::resource('wali-siswa', WaliSiswaController::class);
        Route::get('wali-siswa/{waliSiswa}/monitoring', [WaliSiswaController::class, 'monitoring'])->name('wali-siswa.monitoring');

        Route::resource('kelas', KelasController::class);
        Route::post('kelas/{kela}/assign-wali', [KelasController::class, 'assignWaliKelas'])->name('kelas.assign-wali');

        Route::resource('mata-pelajaran', MataPelajaranController::class);
        
        Route::resource('jadwal', JadwalController::class);
        Route::get('jadwal/kelas/{kelasId}', [JadwalController::class, 'jadwalPerKelas'])->name('jadwal.kelas');

        // QR Code
        Route::get('qr-code', [QRCodeController::class, 'index'])->name('qr-code.index');
        Route::post('qr-code/{siswa}/generate', [QRCodeController::class, 'generate'])->name('qr-code.generate');
        Route::get('qr-code/{siswa}/cetak', [QRCodeController::class, 'cetakKartu'])->name('qr-code.cetak');
        Route::get('qr-code/{siswa}/download', [QRCodeController::class, 'download'])->name('qr-code.download');

        // Presensi & Scan
        Route::get('presensi', [PresensiController::class, 'index'])->name('presensi.index');
        Route::get('presensi/scan', [PresensiController::class, 'scan'])->name('presensi.scan');
        Route::post('presensi/scan/proses', [PresensiController::class, 'prosesScan'])->name('presensi.scan.proses');
        Route::post('presensi/datang', [PresensiController::class, 'presensiDatang'])->name('presensi.datang');
        Route::post('presensi/{presensi}/pulang', [PresensiController::class, 'presensiPulang'])->name('presensi.pulang');

        // Laporan
        Route::get('laporan', [PresensiController::class, 'laporan'])->name('laporan.index');
        Route::get('laporan/pdf', [PresensiController::class, 'exportPDF'])->name('laporan.pdf');
        Route::get('laporan/excel', [PresensiController::class, 'exportExcel'])->name('laporan.excel');
    });

    // ==========================================
    // GURU ROUTES
    // ==========================================
    Route::middleware('guru')->prefix('guru')->name('guru.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'guru'])->name('dashboard');
        Route::get('/jadwal', [JadwalController::class, 'guruJadwal'])->name('jadwal');
        Route::get('/presensi', [PresensiController::class, 'guruPresensi'])->name('presensi');
        
        // Scan QR oleh Guru
        Route::get('/scan', [PresensiController::class, 'scan'])->name('scan');
        Route::post('/scan/proses', [PresensiController::class, 'prosesScan'])->name('scan.proses');

        // Monitoring & Laporan
        Route::get('/monitoring', [MonitoringController::class, 'index'])->name('monitoring');
        Route::get('/monitoring/status', [MonitoringController::class, 'status'])->name('monitoring.status');
        Route::get('/laporan', [PresensiController::class, 'laporan'])->name('laporan');
    });

    // ==========================================
    // SISWA ROUTES
    // ==========================================
    Route::middleware('siswa')->prefix('siswa')->name('siswa.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'siswa'])->name('dashboard');
        Route::get('/jadwal', [JadwalController::class, 'siswaJadwal'])->name('jadwal');
        Route::get('/presensi', [PresensiController::class, 'siswaPresensi'])->name('presensi');
        Route::get('/qr-code', function () {
            return view('siswa.qr-code', ['siswa' => Auth::user()->siswa]);
        })->name('qr-code');
    });

    // ==========================================
    // WALI SISWA ROUTES
    // ==========================================
    Route::middleware('wali_siswa')->prefix('wali')->name('wali.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'waliSiswa'])->name('dashboard');
        Route::get('/siswa', function () {
            return view('wali.siswa', ['siswa' => Auth::user()->waliSiswa->siswa]);
        })->name('siswa');
        Route::get('/jadwal', [JadwalController::class, 'waliJadwal'])->name('jadwal');
        Route::get('/presensi', [PresensiController::class, 'waliPresensi'])->name('presensi');
    });
});
