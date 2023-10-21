<?php

namespace App\Exports;

use App\Models\KopCabang;
use App\Models\KopPengajuan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class RekapPengajuanExport implements FromView
{
    use Exportable;

    protected $kode_cabang, $rekap_by, $from_date, $thru_date, $format;

    function __construct($kode_cabang, $rekap_by, $from_date, $thru_date, $format)
    {
        $this->kode_cabang = $kode_cabang;
        $this->rekap_by = $rekap_by;
        $this->from_date = $from_date;
        $this->thru_date = $thru_date;
        $this->format = $format;
    }

    function view(): View
    {
        $format = $this->format;

        $show = KopPengajuan::rekap_pengajuan($this->kode_cabang, $this->rekap_by, $this->from_date, $this->thru_date);

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
        $sum_pokok = 0;

        foreach ($show as $sw) {
            $sum_anggota += $sw->jumlah_anggota;
            $sum_pokok += $sw->nominal;
        }

        $total_anggota = 0;
        $total_pokok = 0;

        foreach ($show as $item) {
            $item->persen_jumlah = ($item->jumlah_anggota / $sum_anggota) * 100;
            $item->persen_nominal = ($item->nominal / $sum_pokok) * 100;

            $total_anggota += $item->jumlah_anggota;
            $total_pokok += $item->nominal;
        }

        return view('rekappengajuan', [
            'format' => $format,
            'pengajuan' => $show,
            'cabang' => $cabang,
            'total_anggota' => $total_anggota,
            'total_pokok' => $total_pokok,
            'tanggal1' => date('d/m/Y', strtotime($this->from_date)),
            'tanggal2' => date('d/m/Y', strtotime($this->thru_date))
        ]);
    }
}
