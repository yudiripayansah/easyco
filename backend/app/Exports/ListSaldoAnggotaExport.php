<?php

namespace App\Exports;

use App\Models\KopAnggota;
use App\Models\KopCabang;
use App\Models\KopPegawai;
use App\Models\KopRembug;
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

        if ($this->from_date <> '~' and !empty($this->from_date) and $this->from_date <> null) {
            $from_date = date('Y-m-d', strtotime(str_replace('/', '-', $this->from_date)));
        } else {
            $from_date = '';
        }

        if ($this->thru_date <> '~' and !empty($this->thru_date) and $this->thru_date <> null) {
            $thru_date = date('Y-m-d', strtotime(str_replace('/', '-', $this->thru_date)));
        } else {
            $thru_date = '';
        }

        $show = KopAnggota::report_list($this->kode_cabang, $this->kode_petugas, $this->kode_rembug, $from_date, $thru_date);

        foreach ($show as $item) {
            $item->simpok = (int) $item->simpok;
            $item->simwa = (int) $item->simwa;
            $item->simsuk = (int) $item->simsuk;
            $item->saldo_pokok = (int) $item->saldo_pokok;
            $item->saldo_margin = (int) $item->saldo_margin;
            $item->saldo_taber = (int) $item->saldo_taber;
            $item->saldo_tab_5 = (int) $item->saldo_tab_5;
        }

        return view('listsaldoanggota', [
            'format' => $format,
            'saldoanggota' => $show,
            'cabang' => $cabang
        ]);
    }
}
