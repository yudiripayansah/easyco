<?php

namespace App\Exports;

use App\Models\KopCabang;
use App\Models\KopPegawai;
use App\Models\KopPelunasan;
use App\Models\KopRembug;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class ListPelunasanExport implements FromView
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

        $show = KopPelunasan::get_pelunasan($this->kode_cabang, $this->kode_petugas, $this->kode_rembug, $this->from_date, $this->thru_date);

        if ($this->kode_cabang <> '~' and $this->kode_cabang <> '00000' and !empty($this->kode_cabang) and $this->kode_cabang <> null) {
            $branch = KopCabang::where('kode_cabang', $this->kode_cabang)->first();
            $cabang = $branch->nama_cabang;
        } else {
            $cabang = 'SEMUA CABANG';
        }

        if ($this->kode_petugas <> '~' and $this->kode_petugas <> '00000' and !empty($this->kode_petugas) and $this->kode_petugas <> null) {
            $fa = KopPegawai::where('kode_pgw', $this->kode_petugas)->first();
            $petugas = $fa->nama_pgw;
        } else {
            $petugas = 'SEMUA PETUGAS';
        }

        if ($this->kode_rembug <> '~' and $this->kode_rembug <> '00000' and !empty($this->kode_rembug) and $this->kode_rembug <> null) {
            $cm = KopRembug::where('kode_rembug', $this->kode_rembug)->first();
            $rembug = $cm->nama_rembug;
        } else {
            $rembug = 'SEMUA MAJLIS';
        }

        foreach ($show as $item) {
            $item->tanggal_pelunasan = date('d/m/Y', strtotime(str_replace('-', '/', $item->tanggal_pelunasan)));
            $item->tanggal_jtempo = date('d/m/Y', strtotime(str_replace('-', '/', $item->tanggal_jtempo)));

            if ($item->periode_jangka_waktu == 0) {
                $item->periode = 'Hari';
            } else if ($item->periode_jangka_waktu == 1) {
                $item->periode = 'Minggu';
            } else if ($item->periode_jangka_waktu == 2) {
                $item->periode = 'Bulan';
            } else {
                $item->periode = 'Tempo';
            }
        }

        return view('listpelunasan', [
            'format' => $format,
            'pelunasan' => $show,
            'cabang' => $cabang,
            'petugas' => $petugas,
            'rembug' => $rembug,
            'from_date' => date('d/m/Y', strtotime($this->from_date)),
            'thru_date' => date('d/m/Y', strtotime($this->thru_date))
        ]);
    }
}
