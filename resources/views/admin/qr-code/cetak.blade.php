<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Kartu Siswa - {{ $siswa->user->name }}</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite('resources/css/app.css')
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f1f5f9;
            padding: 20px;
        }
        @media print {
            body {
                background: none;
                padding: 0;
            }
            .no-print {
                display: none;
            }
            .card-container {
                box-shadow: none !important;
                border: 1px solid #cbd5e1 !important;
            }
        }
    </style>
</head>
<body class="flex flex-col items-center justify-center min-h-screen">

    <div class="no-print mb-6">
        <button onclick="window.print()" class="bg-primary-500 hover:bg-primary-600 text-white font-bold py-2.5 px-6 rounded-xl transition duration-200 shadow-lg shadow-primary-500/20 text-sm flex items-center">
            <i class="fa-solid fa-print mr-2"></i> Cetak Sekarang
        </button>
    </div>

    <!-- Student Card -->
    <div class="card-container w-[380px] bg-gradient-to-br from-slate-900 via-slate-800 to-indigo-950 text-white rounded-3xl p-6 shadow-2xl border border-slate-700 relative overflow-hidden">
        <!-- Accent circles -->
        <div class="absolute -right-16 -top-16 w-36 h-36 rounded-full bg-white/5 border border-white/5"></div>
        <div class="absolute -left-16 -bottom-16 w-36 h-36 rounded-full bg-white/5 border border-white/5"></div>

        <!-- Header -->
        <div class="flex items-center space-x-3 pb-4 border-b border-white/10 mb-4">
            <div class="w-10 h-10 rounded-xl bg-primary-500 flex items-center justify-center text-white font-bold text-lg">
                <i class="fa-solid fa-graduation-cap"></i>
            </div>
            <div>
                <h3 class="text-sm font-extrabold tracking-wider uppercase">SMP NEGERI 19</h3>
                <p class="text-[9px] text-slate-400 font-semibold tracking-widest uppercase">KOTA MAKASSAR</p>
            </div>
        </div>

        <!-- Body -->
        <div class="flex space-x-4 items-start">
            <!-- Student Photo -->
            <div class="shrink-0">
                @if($siswa->user->foto)
                    <img src="{{ asset('storage/' . $siswa->user->foto) }}" class="w-24 h-28 rounded-xl object-cover border border-white/15 shadow" alt="Foto">
                @else
                    <div class="w-24 h-28 rounded-xl bg-slate-800 flex items-center justify-center text-slate-450 border border-white/10 shadow-inner">
                        <i class="fa-solid fa-user text-3xl"></i>
                    </div>
                @endif
            </div>

            <!-- Student Info -->
            <div class="flex-1 min-w-0 space-y-2">
                <div>
                    <p class="text-[9px] text-slate-400 font-bold uppercase tracking-wider">Nama Lengkap</p>
                    <p class="text-sm font-bold text-white truncate">{{ $siswa->user->name }}</p>
                </div>
                <div>
                    <p class="text-[9px] text-slate-400 font-bold uppercase tracking-wider">NIS</p>
                    <p class="text-xs font-semibold text-sky-300 font-mono">{{ $siswa->nis }}</p>
                </div>
                <div>
                    <p class="text-[9px] text-slate-400 font-bold uppercase tracking-wider">Kelas</p>
                    <p class="text-xs font-semibold text-white">Kelas {{ $siswa->kelas->nama_kelas }}</p>
                </div>
            </div>
        </div>

        <!-- Footer / QR Code scan info -->
        <div class="mt-5 pt-4 border-t border-white/10 flex items-center justify-between">
            <div class="text-[8px] text-slate-450 uppercase tracking-widest font-semibold">
                KARTU IDENTITAS DIGITAL
            </div>
            <div class="p-1 bg-white rounded-lg shadow shrink-0 border border-slate-700">
                {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(55)->generate($qrCodeText) !!}
            </div>
        </div>
    </div>

</body>
</html>
