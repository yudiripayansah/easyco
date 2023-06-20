<?php

namespace App\Exports;

use App\Models\KopCabang;
use App\Models\KopTrxRembug;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class TransaksiMajelisExport implements FromView
{
    use Exportable;

    protected $branch_code, $fa_code, $cm_code, $from_date, $thru_date, $format;

    function __construct($branch_code, $fa_code, $cm_code, $from_date, $thru_date, $format)
    {
        $this->branch_code = $branch_code;
        $this->fa_code = $fa_code;
        $this->cm_code = $cm_code;
        $this->from_date = $from_date;
        $this->thru_date = $thru_date;
        $this->format = $format;
    }

    function view(): View
    {
        $format = $this->format;

        $show = KopTrxRembug::get_all_transaction($this->branch_code, $this->fa_code, $this->cm_code, $this->from_date, $this->thru_date, 0);

        if ($this->branch_code <> '~') {
            $branch = KopCabang::where('kode_cabang', $this->branch_code)->first();

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
            $penerimaan = KopTrxRembug::total_cashflow($head->kode_rembug, $head->trx_date, 'C');
            $penarikan = KopTrxRembug::total_cashflow($head->kode_rembug, $head->trx_date, 'D');
            $detail = KopTrxRembug::get_detail($head->id_trx_rembug);

            foreach ($detail as $dt) {
                $data[] = $dt;
            }

            if ($head->verified_by <> null) {
                $status = 'Tidak';
            } else {
                $status = 'Ya';
            }

            $head->nama_cabang = $cabang;
            $head->tanggal_bayar = $head->trx_date;
            $head->tanggal = date('Y-m-d', strtotime($head->created_at));
            $head->nama_petugas = $head->nama_pgw;
            $head->total_penerimaan = $penerimaan['amount'];
            $head->total_penarikan = $penarikan['amount'];
            $head->status_verifikasi = $status;
        }

        return view('transaksimajelis', [
            'format' => $format,
            'transaksimajelis' => $show,
            'head' => $head,
            'detail' => $data
        ]);
    }
}
