<table>
    <thead>
        <tr>
            <th colspan="7" style="font-size: 14px; font-weight: bold; text-align: center;">LAPORAN KEHADIRAN SISWA SMPN 19 MAKASSAR</th>
        </tr>
        <tr>
            <th colspan="7" style="font-size: 10px; text-align: center; color: #666;">Generated at: {{ date('Y-m-d H:i:s') }}</th>
        </tr>
        <tr></tr> <!-- Spacer -->
        <tr>
            <th style="font-weight: bold; background-color: #f2f2f2;">Tanggal</th>
            <th style="font-weight: bold; background-color: #f2f2f2;">NIS</th>
            <th style="font-weight: bold; background-color: #f2f2f2;">Nama Siswa</th>
            <th style="font-weight: bold; background-color: #f2f2f2;">Kelas</th>
            <th style="font-weight: bold; background-color: #f2f2f2;">Mata Pelajaran</th>
            <th style="font-weight: bold; background-color: #f2f2f2;">Jam Datang</th>
            <th style="font-weight: bold; background-color: #f2f2f2;">Jam Pulang</th>
            <th style="font-weight: bold; background-color: #f2f2f2;">Status</th>
            <th style="font-weight: bold; background-color: #f2f2f2;">Keterangan</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($presensis as $p)
            <tr>
                <td>{{ $p->tanggal }}</td>
                <td>{{ $p->siswa->nis }}</td>
                <td>{{ $p->siswa->user->name }}</td>
                <td>{{ $p->siswa->kelas->nama_kelas }}</td>
                <td>{{ $p->jadwal->mataPelajaran->nama ?? '-' }}</td>
                <td>{{ $p->jam_datang ? substr($p->jam_datang, 0, 5) : '-' }}</td>
                <td>{{ $p->jam_pulang ? substr($p->jam_pulang, 0, 5) : '-' }}</td>
                <td>{{ ucfirst($p->status) }}</td>
                <td>{{ $p->keterangan ?? '-' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
