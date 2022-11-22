<?php

namespace App\Exports;

use App\Models\KopPengajuan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class ListPengajuanExport implements FromView
{
    use Exportable;

    protected $kode_cabang, $jenis_pembiayaan, $kode_petugas, $kode_rembug, $from_date, $thru_date;

    function __construct($kode_cabang, $jenis_pembiayaan, $kode_petugas, $kode_rembug, $from_date, $thru_date)
    {
        $this->kode_cabang = $kode_cabang;
        $this->jenis_pembiayaan = $jenis_pembiayaan;
        $this->kode_petugas = $kode_petugas;
        $this->kode_rembug = $kode_rembug;
        $this->from_date = $from_date;
        $this->thru_date = $thru_date;
    }

    function view(): View
    {
        $show = KopPengajuan::report_list($this->kode_cabang, $this->jenis_pembiayaan, $this->kode_petugas, $this->kode_rembug, $this->from_date, $this->thru_date);

        return view('listpengajuan', ['pengajuan' => $show]);
    }
}
