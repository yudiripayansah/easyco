<?php

namespace App\Exports;

use App\Models\KopCabang;
use App\Models\KopPar;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class RekapParExport implements FromView
{
    use Exportable;

    protected $kode_cabang, $rekap_by, $tanggal, $format;

    function __construct($kode_cabang, $rekap_by, $tanggal, $format)
    {
        $this->kode_cabang = $kode_cabang;
        $this->rekap_by = $rekap_by;
        $this->tanggal = $tanggal;
        $this->format = $format;
    }

    function view(): View
    {
        $format = $this->format;

        $show = KopPar::rekap_par($this->kode_cabang, $this->rekap_by, $this->tanggal);

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

        $total_jumlah_1 = 0;
        $total_saldo_pokok_1 = 0;
        $total_cpp_1 = 0;
        $total_jumlah_2 = 0;
        $total_saldo_pokok_2 = 0;
        $total_cpp_2 = 0;
        $total_jumlah_3 = 0;
        $total_saldo_pokok_3 = 0;
        $total_cpp_3 = 0;
        $total_jumlah_4 = 0;
        $total_saldo_pokok_4 = 0;
        $total_cpp_4 = 0;
        $total_jumlah_5 = 0;
        $total_saldo_pokok_5 = 0;
        $total_cpp_5 = 0;
        $total_jumlah_6 = 0;
        $total_saldo_pokok_6 = 0;
        $total_cpp_6 = 0;

        foreach ($show as $item) {
            $total_jumlah_1 += $item->jumlah_1;
            $total_saldo_pokok_1 += $item->saldo_pokok_1;
            $total_cpp_1 += $item->cpp_1;
            $total_jumlah_2 += $item->jumlah_2;
            $total_saldo_pokok_2 += $item->saldo_pokok_2;
            $total_cpp_2 += $item->cpp_2;
            $total_jumlah_3 += $item->jumlah_3;
            $total_saldo_pokok_3 += $item->saldo_pokok_3;
            $total_cpp_3 += $item->cpp_3;
            $total_jumlah_4 += $item->jumlah_4;
            $total_saldo_pokok_4 += $item->saldo_pokok_4;
            $total_cpp_4 += $item->cpp_4;
            $total_jumlah_5 += $item->jumlah_5;
            $total_saldo_pokok_5 += $item->saldo_pokok_5;
            $total_cpp_5 += $item->cpp_5;
            $total_jumlah_6 += $item->jumlah_6;
            $total_saldo_pokok_6 += $item->saldo_pokok_6;
            $total_cpp_6 += $item->cpp_6;
        }

        return view('rekappar', [
            'format' => $format,
            'par' => $show,
            'cabang' => $cabang,
            'total_jumlah_1' => $total_jumlah_1,
            'total_saldo_pokok_1' => $total_saldo_pokok_1,
            'total_cpp_1' => $total_cpp_1,
            'total_jumlah_2' => $total_jumlah_2,
            'total_saldo_pokok_2' => $total_saldo_pokok_2,
            'total_cpp_2' => $total_cpp_2,
            'total_jumlah_3' => $total_jumlah_3,
            'total_saldo_pokok_3' => $total_saldo_pokok_3,
            'total_cpp_3' => $total_cpp_3,
            'total_jumlah_4' => $total_jumlah_4,
            'total_saldo_pokok_4' => $total_saldo_pokok_4,
            'total_cpp_4' => $total_cpp_4,
            'total_jumlah_5' => $total_jumlah_5,
            'total_saldo_pokok_5' => $total_saldo_pokok_5,
            'total_cpp_5' => $total_cpp_5,
            'total_jumlah_6' => $total_jumlah_6,
            'total_saldo_pokok_6' => $total_saldo_pokok_6,
            'total_cpp_6' => $total_cpp_6
        ]);
    }
}
