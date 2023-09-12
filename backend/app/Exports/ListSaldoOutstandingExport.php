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

    protected $kode_cabang, $kode_rembug, $kode_petugas, $format;

    function __construct($kode_cabang, $kode_rembug, $kode_petugas, $format)
    {
        $this->kode_cabang = $kode_cabang;
        $this->kode_rembug = $kode_rembug;
        $this->kode_petugas = $kode_petugas;
        $this->format = $format;
    }

    function view(): View
    {
        $format = $this->format;

        if ($this->kode_petugas == 'null') {
            $kode_petugas = '~';
        }

        if ($this->kode_rembug == 'null') {
            $kode_rembug = '~';
        }

        $show = KopPembiayaan::report_list($this->kode_cabang, 9, $kode_petugas, $kode_rembug, 99, '', '', [1], [1], 2);

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
