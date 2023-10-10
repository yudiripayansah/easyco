<?php

namespace App\Exports;

use App\Models\KopCabang;
use App\Models\KopPar;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class ListKolektibilitasExport implements FromView
{
    use Exportable;

    protected $kode_cabang, $tanggal_hitung, $format;

    function __construct($kode_cabang, $tanggal_hitung, $format)
    {
        $this->kode_cabang = $kode_cabang;
        $this->tanggal_hitung = $tanggal_hitung;
        $this->format = $format;
    }

    function view(): View
    {
        $format = $this->format;

        if ($this->tanggal_hitung) {
            $tanggal_hitung = date('Y-m-d', strtotime(str_replace('/', '-', $this->tanggal_hitung)));
        } else {
            $tanggal_hitung = date('Y-m-d');
        }

        $show = KopPar::get_kolektibilitas($this->kode_cabang, $tanggal_hitung, '~', 0, 0);

        if ($this->kode_cabang <> '00000') {
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
            $item->tanggal_akad = date('d/m/Y', strtotime(str_replace('-', '/', $item->tanggal_akad)));
            $item->tanggal_mulai_angsur = date('d/m/Y', strtotime(str_replace('-', '/', $item->tanggal_mulai_angsur)));
        }

        return view('listkolektibilitas', [
            'format' => $format,
            'kolektibilitas' => $show,
            'cabang' => $cabang,
            'tanggal_hitung' => date('d/m/Y', strtotime($tanggal_hitung))
        ]);
    }
}
