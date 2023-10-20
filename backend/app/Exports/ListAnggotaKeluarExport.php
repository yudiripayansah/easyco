<?php

namespace App\Exports;

use App\Models\KopAnggotaMutasi;
use App\Models\KopCabang;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class ListAnggotaKeluarExport implements FromView
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

        if ($this->kode_cabang <> '~' and $this->kode_cabang <> '00000' and !empty($this->kode_cabang) and $this->kode_cabang <> null) {
            $branch = KopCabang::where('kode_cabang', $this->kode_cabang)->first();

            if ($branch <> '00000') {
                $cabang = $branch->nama_cabang;
            } else {
                $cabang = 'SEMUA CABANG';
            }
        } else {
            $cabang = 'SEMUA CABANG';
        }

        if ($this->kode_rembug <> '~' and $this->kode_rembug <> '00000' and !empty($this->kode_rembug) and $this->kode_rembug <> null) {
            $kode_rembug = '00000';
        } else {
            $kode_rembug = $this->kode_rembug;
        }

        if ($this->from_date) {
            $from_date = date('Y-m-d', strtotime(str_replace('/', '-', $this->from_date)));
        } else {
            $from_date = date('Y-m-d');
        }

        if ($this->thru_date) {
            $thru_date = date('Y-m-d', strtotime(str_replace('/', '-', $this->thru_date)));
        } else {
            $thru_date = date('Y-m-d');
        }

        $show = KopAnggotaMutasi::get_anggota_keluar($this->kode_cabang, $kode_rembug, $from_date, $thru_date);

        foreach ($show as $item) {
            $item->penarikan_sukarela = $item->setoran_tambahan + $item->penarikan_sukarela;
        }

        return view('listanggotakeluar', [
            'format' => $format,
            'anggotakeluar' => $show,
            'cabang' => $cabang,
            'tanggal1' => date('d/m/Y', strtotime($from_date)),
            'tanggal2' => date('d/m/Y', strtotime($thru_date))
        ]);
    }
}
