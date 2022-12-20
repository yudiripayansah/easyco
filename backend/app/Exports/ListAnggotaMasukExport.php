<?php

namespace App\Exports;

use App\Models\KopAnggota;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class ListAnggotaMasukExport implements FromView
{
    use Exportable;

    protected $kode_cabang, $kode_rembug, $from_date, $thru_date;

    function __construct($kode_cabang, $kode_rembug, $from_date, $thru_date)
    {
        $this->kode_cabang = $kode_cabang;
        $this->kode_rembug = $kode_rembug;
        $this->from_date = $from_date;
        $this->thru_date = $thru_date;
    }

    function view(): View
    {
        $show = KopAnggota::report_list($this->kode_cabang, $this->kode_rembug, $this->from_date, $this->thru_date);

        foreach ($show as $item) {
            $item->tgl_gabung = date('d/m/Y', strtotime($item->tgl_gabung));
        }

        return view('listanggotamasuk', ['anggotamasuk' => $show]);
    }
}
