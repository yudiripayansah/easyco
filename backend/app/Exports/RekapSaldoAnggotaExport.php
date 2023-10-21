<?php

namespace App\Exports;

use App\Models\KopAnggota;
use App\Models\KopCabang;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class RekapSaldoAnggotaExport implements FromView
{
    use Exportable;

    protected $kode_cabang, $rekap_by, $format;

    function __construct($kode_cabang, $rekap_by, $format)
    {
        $this->kode_cabang = $kode_cabang;
        $this->rekap_by = $rekap_by;
        $this->format = $format;
    }

    function view(): View
    {
        $format = $this->format;

        $show = KopAnggota::rekap_saldo_anggota($this->kode_cabang, $this->rekap_by);

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

        $total_anggota = 0;
        $total_simwa = 0;
        $total_simpok = 0;
        $total_simsuk = 0;
        $total_saldo_pokok = 0;
        $total_saldo_margin = 0;
        $total_saldo_catab = 0;

        foreach ($show as $item) {
            $total_anggota += $item->jumlah_anggota;
            $total_simwa += $item->simwa;
            $total_simpok += $item->simpok;
            $total_simsuk += $item->simsuk;
            $total_saldo_pokok += $item->saldo_pokok;
            $total_saldo_margin += $item->saldo_margin;
            $total_saldo_catab += $item->saldo_catab;
        }

        return view('rekapsaldoanggota', [
            'format' => $format,
            'saldoanggota' => $show,
            'cabang' => $cabang,
            'total_anggota' => $total_anggota,
            'total_simwa' => $total_simwa,
            'total_simpok' => $total_simpok,
            'total_simsuk' => $total_simsuk,
            'total_saldo_pokok' => $total_saldo_pokok,
            'total_saldo_margin' => $total_saldo_margin,
            'total_saldo_catab' => $total_saldo_catab
        ]);
    }
}
