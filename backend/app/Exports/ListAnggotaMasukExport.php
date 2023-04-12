<?php

namespace App\Exports;

use App\Models\KopAnggota;
use App\Models\KopCabang;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class ListAnggotaMasukExport implements FromView
{
    use Exportable;

    protected $kode_cabang, $kode_rembug, $from_date, $thru_date, $format;

    function __construct($kode_cabang, $kode_rembug, $from_date, $thru_date, $format)
    {
        $this->kode_cabang = $kode_cabang;
        $this->kode_rembug = $kode_rembug;
        $this->from_date = $from_date;
        $this->thru_date = $thru_date;
        $this->format = $format;
    }

    function view(): View
    {
        $format = $this->format;

        $show = KopAnggota::report_list($this->kode_cabang, $this->kode_rembug, $this->from_date, $this->thru_date);

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

        foreach ($show as $item) {
            $item->tgl_gabung = date('d/m/Y', strtotime($item->tgl_gabung));
        }

        return view('listanggotamasuk', [
            'format' => $format,
            'anggotamasuk' => $show,
            'cabang' => $cabang,
            'tanggal1' => date('d/m/Y', strtotime($this->from_date)),
            'tanggal2' => date('d/m/Y', strtotime($this->thru_date))
        ]);
    }
}
