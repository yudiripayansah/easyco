<?php

namespace App\Exports;

use App\Models\KopAnggota;
use App\Models\KopCabang;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class ListSaldoAnggotaExport implements FromView
{
    use Exportable;

    protected $kode_cabang, $kode_petugas, $kode_rembug, $from_date, $thru_date, $format;

    function __construct($kode_cabang, $kode_petugas, $kode_rembug, $from_date, $thru_date, $format)
    {
        $this->kode_cabang = $kode_cabang;
        $this->kode_petugas = $kode_petugas;
        $this->kode_rembug = $kode_rembug;
        $this->from_date = $from_date;
        $this->thru_date = $thru_date;
        $this->format = $format;
    }

    function view(): View
    {
        $format = $this->format;

        $show = KopAnggota::report_list($this->kode_cabang, $this->kode_petugas, $this->kode_rembug, $this->from_date, $this->thru_date);

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

        return view('listsaldoanggota', [
            'format' => $format,
            'saldoanggota' => $show,
            'cabang' => $cabang
        ]);
    }
}
