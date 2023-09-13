<?php

namespace App\Exports;

use App\Models\KopAnggota;
use App\Models\KopTrxAnggota;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class StatementTabunganExport implements FromView
{
    use Exportable;

    protected $no_anggota, $jenis_tabungan, $no_rekening, $from_date, $thru_date, $format;

    function __construct($no_anggota, $jenis_tabungan, $no_rekening, $from_date, $thru_date, $format)
    {
        $this->no_anggota = $no_anggota;
        $this->jenis_tabungan = $jenis_tabungan;
        $this->no_rekening = $no_rekening;
        $this->from_date = $from_date;
        $this->thru_date = $thru_date;
        $this->format = $format;
    }

    function view(): View
    {
        $format = $this->format;

        if ($this->from_date) {
            $from_date = date('Y-m-d', strtotime(str_replace('/', '-', $this->from_date)));
        } else {
            $from_date = date('Y-m-d');
        }

        if ($this->thru_date) {
            $thru_date = date('Y-m-d', strtotime(str_replace('/', '-', $this->thru_date)));
        } else {
            $thru_date = date('Y-m-d');
        }

        $nama = KopAnggota::get_profile($this->no_anggota);

        if ($this->jenis_tabungan == 1) {
            // Tabungan Sukarela
            $get_credit = KopTrxAnggota::get_credit_member($this->no_anggota, 13, $from_date);
            $get_debet = KopTrxAnggota::get_debet_member($this->no_anggota, 22, $from_date);

            $credit = (isset($get_credit->amount) ? $get_credit->amount : 0);
            $debet = (isset($get_debet->amount) ? $get_debet->amount : 0);

            $saldo_awal = $credit - $debet;
            $saldo_akhir = $saldo_awal;

            $show = KopTrxAnggota::get_history_member($this->no_anggota, [13, 22], $from_date, $thru_date);
        } elseif ($this->jenis_tabungan == 2) {
            // Tabungan Berencana
            $get_credit = KopTrxAnggota::get_history_dc_member($this->no_rekening, 'C', $from_date);
            $get_debet = KopTrxAnggota::get_history_dc_member($this->no_rekening, 'D', $from_date);

            $credit = (isset($get_credit->amount) ? $get_credit->amount : 0);
            $debet = (isset($get_debet->amount) ? $get_debet->amount : 0);

            $saldo_awal = $credit - $debet;
            $saldo_akhir = $saldo_awal;

            $show = KopTrxAnggota::get_history_savingplan($this->no_rekening, $from_date, $thru_date);
        } else {
            // Simpanan Wajib / Minggon
            $get_credit = KopTrxAnggota::get_credit_member($this->no_anggota, 12, $from_date);
            $get_debet = 0;

            $credit = (isset($get_credit->amount) ? $get_credit->amount : 0);
            $debet = 0;

            $saldo_awal = $credit - $debet;
            $saldo_akhir = $saldo_awal;

            $show = KopTrxAnggota::get_history_member($this->no_anggota, [12], $from_date, $thru_date);
        }

        $data = array();

        for ($i = 0; $i < count($show); $i++) {
            $trx_date = $show[$i]->trx_date;
            $amount = $show[$i]->amount;
            $flag_debet_credit = $show[$i]->flag_debet_credit;
            $description = $show[$i]->description;

            if ($flag_debet_credit == 'C') {
                $history_credit = $amount;
                $setor = $history_credit;
                $tarik = 0;
            } else {
                $history_debet = $amount;
                $setor = 0;
                $tarik = $history_debet;
            }

            $saldo_akhir += $setor - $tarik;

            $data[] = array(
                'trx_date' => $trx_date,
                'setor' => (int) $setor,
                'tarik' => (int) $tarik,
                'saldo_akhir' => (int) $saldo_akhir,
                'keterangan' => $description
            );
        }

        return view('statementtabungan', [
            'format' => $format,
            'nama' => $nama->nama_anggota,
            'tanggal1' => date('d/m/Y', strtotime($from_date)),
            'tanggal2' => date('d/m/Y', strtotime($thru_date)),
            'saldo_awal' => $saldo_awal,
            'statementtabungan' => $data
        ]);
    }
}
