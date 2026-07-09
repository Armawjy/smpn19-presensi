<?php

namespace App\Exports;

use App\Models\Presensi;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class LaporanPresensiExport implements FromView, ShouldAutoSize
{
    protected $presensis;

    public function __construct($presensis)
    {
        $this->presensis = $presensis;
    }

    public function view(): View
    {
        return view('admin.laporan.excel', [
            'presensis' => $this->presensis
        ]);
    }
}
