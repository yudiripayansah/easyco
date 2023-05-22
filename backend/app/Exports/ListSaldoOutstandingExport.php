<?php

namespace App\Exports;

use App\Models\KopCabang;
use App\Models\KopPembiayaan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class ListSaldoOutstandingExport implements FromView
{
    use Exportable;

    protected $kode_cabang, $kode_rembug, $format;

    function __construct($kode_cabang, $kode_rembug, $format)
    {
        $this->kode_cabang = $kode_cabang;
        $this->kode_rembug = $kode_rembug;
        $this->format = $format;
    }

    function view(): View
    {
        $format = $this->format;

        $show = KopPembiayaan::report_list($this->kode_cabang, 9, '~', $this->kode_rembug, 99, '', '', [1], [1], 2);

        if ($this->kode_cabang <> '~') {
            $branch = KopCabang::where('kode_cabang', $this->kode_cabang)->first();

            if ($branch <> '00000') {
                $cabang = $branch->nama_cabang;
            } else {
                $cabang = 'SEMUA CABANG';
            }
        } else {
            $cabang = 'SEMUA CABANG';
        }

        return view('listsaldooutstanding', [
            'format' => $format,
            'saldooutstanding' => $show,
            'cabang' => $cabang
        ]);
    }
}
