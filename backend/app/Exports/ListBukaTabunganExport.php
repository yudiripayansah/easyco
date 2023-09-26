<?php

namespace App\Exports;

use App\Models\KopCabang;
use App\Models\KopPrdTabungan;
use App\Models\KopTabungan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class ListBukaTabunganExport implements FromView
{
    use Exportable;

    protected $kode_cabang, $kode_produk, $from_date, $thru_date, $format;

    function __construct($kode_cabang, $kode_produk, $from_date, $thru_date, $format)
    {
        $this->kode_cabang = $kode_cabang;
        $this->kode_produk = $kode_produk;
        $this->from_date = $from_date;
        $this->thru_date = $thru_date;
        $this->format = $format;
    }

    function view(): View
    {
        $format = $this->format;

        $show = KopTabungan::get_report_buka_tabungan($this->kode_cabang, $this->kode_produk, $this->from_date, $this->thru_date);

        if ($this->kode_cabang <> '~' and $this->kode_cabang <> '00000' and !empty($this->kode_cabang) and $this->kode_cabang <> null) {
            $branch = KopCabang::where('kode_cabang', $this->kode_cabang)->first();
            $cabang = $branch->nama_cabang;
        } else {
            $cabang = 'SEMUA CABANG';
        }

        if ($this->kode_produk <> '~' and $this->kode_produk <> '00000' and !empty($this->kode_produk) and $this->kode_produk <> null) {
            $product = KopPrdTabungan::where('kode_produk', $this->kode_produk)->first();
            $tabungan = $product->nama_pgw;
        } else {
            $tabungan = 'SEMUA PRODUK';
        }

        foreach ($show as $item) {
            if ($item->periode_setoran == 0) {
                $item->periode = 'Hari';
            } else if ($item->periode_setoran == 1) {
                $item->periode = 'Minggu';
            } else if ($item->periode_setoran == 2) {
                $item->periode = 'Bulan';
            }
        }

        return view('listbukatabungan', [
            'format' => $format,
            'bukatabungan' => $show,
            'cabang' => $cabang,
            'produk' => $tabungan,
            'from_date' => date('d/m/Y', strtotime($this->from_date)),
            'thru_date' => date('d/m/Y', strtotime($this->thru_date))
        ]);
    }
}
