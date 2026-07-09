@extends('layouts.app')

@section('title', 'Kamera Scanner Presensi Guru')
@section('page_title', 'Scan QR Code Siswa')
@section('page_subtitle', 'Pindai kehadiran siswa untuk mata pelajaran Anda')

@section('content')
<div class="max-w-2xl mx-auto">
    <x-card>
        <div class="flex flex-col items-center">
            
            <div class="w-full max-w-md bg-slate-900 border-4 border-slate-950 rounded-3xl overflow-hidden shadow-xl aspect-video relative flex flex-col items-center justify-center mb-6">
                <div id="reader" class="w-full h-full"></div>
                <div id="scanner-placeholder" class="absolute inset-0 flex flex-col items-center justify-center text-white bg-slate-900 z-10 p-6 text-center">
                    <div class="w-12 h-12 border-4 border-primary-500 border-t-transparent rounded-full animate-spin mb-4"></div>
                    <p class="text-sm font-bold">Menginisialisasi Kamera Scanner...</p>
                    <p class="text-xs text-gray-400 mt-1">Harap berikan izin akses kamera jika diminta</p>
                </div>
            </div>

            <div class="w-full bg-slate-50 border border-gray-150 rounded-2xl p-4 text-center">
                <h4 class="text-sm font-bold text-gray-800 flex items-center justify-center">
                    <i class="fa-solid fa-circle-info text-primary-500 mr-2"></i> Mode Scan Pengajar
                </h4>
                <p class="text-xs text-gray-500 mt-1.5">
                    Scan kartu QR siswa untuk mencatat kehadiran pelajaran hari ini secara otomatis.
                </p>
            </div>
            
            <audio id="success-sound" src="https://assets.mixkit.co/active_storage/sfx/2869/2869-600.wav" preload="auto"></audio>

        </div>
    </x-card>
</div>
@endsection

@section('scripts')
<script src="https://unpkg.com/html5-qrcode"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const placeholder = document.getElementById('scanner-placeholder');
        const successSound = document.getElementById('success-sound');
        let html5QrcodeScanner = null;
        let lastScannedCode = "";
        let scanThrottle = false;

        const scanUrl = '{{ route('guru.scan.proses') }}';

        function onScanSuccess(decodedText, decodedResult) {
            if (scanThrottle || decodedText === lastScannedCode) return;
            
            scanThrottle = true;
            lastScannedCode = decodedText;
            
            if (successSound) {
                successSound.play().catch(e => console.log('Audio play failed:', e));
            }

            fetch(scanUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ qr_code: decodedText })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Presensi Berhasil!',
                        html: `<div class="text-left bg-slate-50 p-4 rounded-xl border border-gray-150 text-sm">
                                <p class="mb-1"><strong>Nama:</strong> ${data.name}</p>
                                <p class="mb-1"><strong>NIS:</strong> ${data.nis}</p>
                                <p class="mb-1"><strong>Jam:</strong> ${data.time}</p>
                               <p class="mt-2 text-emerald-600 font-bold">${data.message}</p>
                               </div>`,
                        confirmButtonColor: '#0ea5e9',
                        confirmButtonText: 'Lanjutkan',
                        customClass: {
                            popup: 'rounded-2xl',
                            confirmButton: 'rounded-xl font-bold py-2 px-4 text-sm'
                        }
                    }).then(() => {
                        scanThrottle = false;
                        lastScannedCode = "";
                    });
                } else {
                    showErrorAlert(data.message);
                }
            })
            .catch(error => {
                showErrorAlert('Terjadi kesalahan jaringan atau sistem gagal memproses.');
            });
        }

        function showErrorAlert(message) {
            Swal.fire({
                icon: 'error',
                title: 'Scan Gagal',
                text: message,
                confirmButtonColor: '#ef4444',
                confirmButtonText: 'Ulangi',
                customClass: {
                    popup: 'rounded-2xl',
                    confirmButton: 'rounded-xl font-bold py-2 px-4 text-sm'
                }
            }).then(() => {
                scanThrottle = false;
                lastScannedCode = "";
            });
        }

        html5QrcodeScanner = new Html5Qrcode("reader");
        html5QrcodeScanner.start(
            { facingMode: "environment" },
            {
                fps: 15,
                qrbox: { width: 250, height: 250 }
            },
            onScanSuccess
        )
        .then(() => {
            if (placeholder) placeholder.style.display = 'none';
        })
        .catch(err => {
            if (placeholder) {
                placeholder.innerHTML = `
                    <i class="fa-solid fa-circle-exclamation text-red-500 text-3xl mb-3"></i>
                    <p class="text-sm font-bold">Kamera Gagal Diakses</p>
                    <p class="text-xs text-gray-400 mt-1">${err.message || 'Coba periksa izin kamera pada browser Anda'}</p>
                `;
            }
        });
    });
</script>
@endsection
