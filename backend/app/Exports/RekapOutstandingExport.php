<?php

namespace App\Exports;

use App\Models\KopCabang;
use App\Models\KopPembiayaan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class RekapOutstandingExport implements FromView
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

        $show = KopPembiayaan::rekap_outstanding($this->kode_cabang, $this->rekap_by);

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

        $sum_anggota = 0;
        $sum_saldo_pokok = 0;

        foreach ($show as $sw) {
            $sum_anggota += $sw->jumlah_anggota;
            $sum_saldo_pokok += $sw->saldo_pokok;
        }

        $total_anggota = 0;
        $total_saldo_pokok = 0;
        $total_saldo_margin = 0;
        $total_saldo_catab = 0;

        foreach ($show as $item) {
            $item->persen_jumlah = number_format(($item->jumlah_anggota / $sum_anggota) * 100, 2, ',', '.');
            $item->persen_nominal = number_format(($item->saldo_pokok / $sum_saldo_pokok) * 100, 2, ',', '.');

            $total_anggota += $item->jumlah_anggota;
            $total_saldo_pokok += $item->saldo_pokok;
            $total_saldo_margin += $item->saldo_margin;
            $total_saldo_catab += $item->saldo_catab;
        }

        return view('rekapoutstanding', [
            'format' => $format,
            'outstanding' => $show,
            'cabang' => $cabang,
            'total_anggota' => $total_anggota,
            'total_saldo_pokok' => $total_saldo_pokok,
            'total_saldo_margin' => $total_saldo_margin,
            'total_saldo_catab' => $total_saldo_catab
        ]);
    }
}
