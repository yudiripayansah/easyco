<?php

namespace App\Exports;

use App\Models\KopCabang;
use App\Models\KopKasPetugasTemporary;
use App\Models\KopTrxKasPetugas;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class ListSaldoKasPetugasExport implements FromView
{
    use Exportable;

    protected $kode_cabang, $tanggal, $created_by, $format;

    function __construct($kode_cabang, $tanggal, $created_by, $format)
    {
        $this->kode_cabang = $kode_cabang;
        $this->tanggal = $tanggal;
        $this->created_by = $created_by;
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

        KopTrxKasPetugas::fn_saldo_kas($this->kode_cabang, $this->tanggal, $this->created_by);

        $show = KopKasPetugasTemporary::get_cash_history($this->kode_cabang, $this->tanggal, $this->created_by);

        $total_saldo_awal = 0;
        $total_saldo_akhir = 0;

        foreach ($show as $item) {
            $item->kode_kas_petugas = $item->kode_kas_petugas;
            $item->nama_kas_petugas = $item->nama_kas_petugas;
            $item->saldo_awal = (int) $item->saldo_awal;
            $item->mutasi_debet = (int) $item->mutasi_debet;
            $item->mutasi_credit = (int) $item->mutasi_credit;
            $item->saldo_akhir = (int) $item->saldo_akhir;

            $total_saldo_awal += $item->saldo_awal;
            $total_saldo_akhir += $item->saldo_akhir;
        }

        $get = KopKasPetugasTemporary::where('created_by', $this->created_by)->first();
        if ($get) {
            KopKasPetugasTemporary::find($get->id)->forceDelete();
        }

        return view('listsaldokaspetugas', [
            'format' => $format,
            'saldokaspetugas' => $show,
            'cabang' => $cabang,
            'tanggal' => date('d/m/Y', strtotime(str_replace('-', '/', $this->tanggal))),
            'total_saldo_awal' => $total_saldo_awal,
            'total_saldo_akhir' => $total_saldo_akhir
        ]);
    }
}
