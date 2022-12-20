<?php

namespace App\Exports;

use App\Models\KopPembiayaan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class ListPencairanExport implements FromView
{
    use Exportable;

    protected $kode_cabang, $jenis_pembiayaan, $kode_petugas, $kode_rembug, $produk, $from_date, $thru_date;

    function __construct($kode_cabang, $jenis_pembiayaan, $kode_petugas, $kode_rembug, $produk, $from_date, $thru_date)
    {
        $this->kode_cabang = $kode_cabang;
        $this->jenis_pembiayaan = $jenis_pembiayaan;
        $this->kode_petugas = $kode_petugas;
        $this->kode_rembug = $kode_rembug;
        $this->produk = $produk;
        $this->from_date = $from_date;
        $this->thru_date = $thru_date;
    }

    function view(): View
    {
        $show = KopPembiayaan::report_list($this->kode_cabang, $this->jenis_pembiayaan, $this->kode_petugas, $this->kode_rembug, $this->produk, $this->from_date, $this->thru_date, [1, 2, 3], [1], 1);

        foreach ($show as $item) {
            $item->nama_kas_petugas = explode('.', $item->nama_kas_petugas);
            $item->nama_petugas = $item->nama_kas_petugas[0];
            $item->tanggal_akad = date('d/m/Y', strtotime($item->tanggal_akad));
        }

        return view('listpencairan', ['pencairan' => $show]);
    }
}
