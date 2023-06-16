<?php

namespace App\Exports;

use App\Models\KopCabang;
use App\Models\KopTrxGl;
use App\Models\KopTrxGlDetail;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class JurnalTransaksiExport implements FromView
{
    use Exportable;

    protected $kode_cabang, $from_date, $thru_date, $format;

    function __construct($kode_cabang, $from_date, $thru_date, $format)
    {
        $this->kode_cabang = $kode_cabang;
        $this->from_date = $from_date;
        $this->thru_date = $thru_date;
        $this->format = $format;
    }

    function view(): View
    {
        $format = $this->format;

        $show = KopTrxGl::get_ledger($this->kode_cabang, $this->from_date, $this->thru_date);

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

        $data = array();

        foreach ($show as $head) {
            $detail = KopTrxGlDetail::get_ledger_detail($head->id_trx_gl);

            foreach ($detail as $dt) {
                $data[] = $dt;
            }

            $head->nama_cabang = $cabang;
            $head->from_date = $this->from_date;
            $head->thru_date = $this->thru_date;
            $head->jumlah = $detail->count();
        }

        return view('jurnaltransaksi', [
            'format' => $format,
            'jurnaltransaksi' => $show,
            'head' => $head,
            'detail' => $data
        ]);
    }
}
