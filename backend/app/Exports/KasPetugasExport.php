<?php

namespace App\Exports;

use App\Models\KopTrxKasPetugas;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class KasPetugasExport implements FromView
{
    use Exportable;

    protected $kode_kas_petugas, $from_date, $thru_date, $format;

    function __construct($kode_kas_petugas, $from_date, $thru_date, $format)
    {
        $this->kode_kas_petugas = $kode_kas_petugas;
        $this->from_date = $from_date;
        $this->thru_date = $thru_date;
        $this->format = $format;
    }

    function view(): View
    {
        $format = $this->format;

        $show = KopTrxKasPetugas::get_history_cash($this->kode_kas_petugas, $this->from_date, $this->thru_date);
        $detail = KopTrxKasPetugas::get_detail_cash($this->kode_kas_petugas);

        $detail->from_date = $this->from_date;
        $detail->thru_date = $this->thru_date;

        return view('kaspetugas', [
            'format' => $format,
            'kaspetugas' => $show,
            'detail' => $detail
        ]);
    }
}
