<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Barryvdh\DomPDF\Facade\Pdf;

class QRCodeController extends Controller
{
    public function index()
    {
        $siswas = Siswa::with(['user', 'kelas'])->paginate(10);
        return view('admin.qr-code.index', compact('siswas'));
    }

    public function generate(Siswa $siswa)
    {
        $qrCodeText = 'SMPN19-' . $siswa->nis;
        $siswa->update(['qr_code' => $qrCodeText]);

        return back()->with('success', 'QR Code berhasil digenerate.');
    }

    public function cetakKartu(Siswa $siswa)
    {
        $qrCodeText = $siswa->qr_code ?? ('SMPN19-' . $siswa->nis);
        
        // Generate SVG or PNG format.
        // QrCode::size(150)->generate($qrCodeText)
        return view('admin.qr-code.cetak', compact('siswa', 'qrCodeText'));
    }

    public function download(Siswa $siswa)
    {
        $qrCodeText = $siswa->qr_code ?? ('SMPN19-' . $siswa->nis);
        
        // Return download of QR Code image. Since Simple-QRCode generates SVG out of the box without Imagick extension,
        // we can download it as SVG file.
        $headers = [
            'Content-Type' => 'image/svg+xml',
            'Content-Disposition' => 'attachment; filename="qrcode_' . $siswa->nis . '.svg"',
        ];

        $svgContent = QrCode::size(300)->generate($qrCodeText);

        return response($svgContent, 200, $headers);
    }

    public function siswaQR(Siswa $siswa)
    {
        return view('admin.qr-code.show', compact('siswa'));
    }
}
