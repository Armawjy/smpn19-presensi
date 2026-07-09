<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Presensi Siswa - SMPN 19 Makassar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #333;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0;
            font-size: 16px;
            text-transform: uppercase;
        }
        .header p {
            margin: 5px 0 0 0;
            font-size: 10px;
            color: #666;
        }
        .title {
            text-align: center;
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 15px;
            text-transform: uppercase;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .status {
            text-transform: uppercase;
            font-weight: bold;
            text-align: center;
        }
        .status-hadir { color: green; }
        .status-izin { color: blue; }
        .status-sakit { color: orange; }
        .status-alpha { color: red; }
    </style>
</head>
<body>

    <div class="header">
        <h2>SMP NEGERI 19 MAKASSAR</h2>
        <p>Jl. Tamangapa Raya No.19, Manggala, Kec. Manggala, Kota Makassar, Sulawesi Selatan 90235</p>
    </div>

    <div class="title">
        LAPORAN KEHADIRAN SISWA
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 12%">Tanggal</th>
                <th style="width: 25%">Nama Siswa</th>
                <th style="width: 10%">Kelas</th>
                <th style="width: 20%">Mata Pelajaran</th>
                <th style="width: 11%">Jam Datang</th>
                <th style="width: 11%">Jam Pulang</th>
                <th style="width: 11%; text-align: center;">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($presensis as $p)
                <tr>
                    <td>{{ $p->tanggal }}</td>
                    <td><strong>{{ $p->siswa->user->name }}</strong></td>
                    <td>{{ $p->siswa->kelas->nama_kelas }}</td>
                    <td>{{ $p->jadwal->mataPelajaran->nama ?? '-' }}</td>
                    <td>{{ $p->jam_datang ? substr($p->jam_datang, 0, 5) : '-' }}</td>
                    <td>{{ $p->jam_pulang ? substr($p->jam_pulang, 0, 5) : '-' }}</td>
                    <td class="status text-center">
                        <span class="status-{{ $p->status }}">{{ $p->status }}</span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 20px; color: #999;">Tidak ada data laporan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>
