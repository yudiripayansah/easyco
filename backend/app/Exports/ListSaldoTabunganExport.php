<?php

namespace App\Exports;

use App\Models\KopCabang;
use App\Models\KopPrdTabungan;
use App\Models\KopTabungan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class ListSaldoTabunganExport implements FromView
{
    use Exportable;

    protected $kode_cabang, $kode_produk, $format;

    function __construct($kode_cabang, $kode_produk, $format)
    {
        $this->kode_cabang = $kode_cabang;
        $this->kode_produk = $kode_produk;
        $this->format = $format;
    }

    function view(): View
    {
        $format = $this->format;

        $show = KopTabungan::get_report_tabungan($this->kode_cabang, $this->kode_produk, '~', 0, 0);

        if ($this->kode_cabang <> '~' and $this->kode_cabang <> '00000' and !empty($this->kode_cabang) and $this->kode_cabang <> null) {
            $branch = KopCabang::where('kode_cabang', $this->kode_cabang)->first();
            $cabang = $branch->nama_cabang;
        } else {
            $cabang = 'SEMUA CABANG';
        }

        if ($this->kode_produk <> '~' and $this->kode_produk <> '00000' and !empty($this->kode_produk) and $this->kode_produk <> null) {
            $product = KopPrdTabungan::where('kode_produk', $this->kode_produk)->first();
            $tabungan = $product->nama_produk;
        } else {
            $tabungan = 'SEMUA PRODUK';
        }

        return view('listsaldotabungan', [
            'format' => $format,
            'saldotabungan' => $show,
            'cabang' => $cabang,
            'produk' => $tabungan
        ]);
    }
}
