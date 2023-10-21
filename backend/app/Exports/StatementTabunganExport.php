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

        $data = array();

        if ($this->jenis_tabungan == 1) {
            // Tabungan Sukarela
            $get_credit = KopTrxAnggota::get_credit_member($this->no_anggota, [13], $from_date);
            $get_debet = KopTrxAnggota::get_debet_member($this->no_anggota, [22], $from_date);
            $get_pinbuk = KopTrxAnggota::get_pinbuk_member($this->no_anggota, [41, 42, 43, 44], $from_date);

            $credit = (isset($get_credit->amount) ? $get_credit->amount : 0);
            $debet = (isset($get_debet->amount) ? $get_debet->amount : 0);
            $pinbuk = (isset($get_pinbuk->amount) ? $get_pinbuk->amount : 0);

            $saldo_awal = ($credit + $pinbuk) - $debet;
            $saldo_akhir = $saldo_awal;

            $show = KopTrxAnggota::get_history_member($this->no_anggota, [13, 22, 41, 42, 43, 44], $from_date, $thru_date);
        } elseif ($this->jenis_tabungan == 2) {
            // Tabungan Berencana
            $get_credit = KopTrxAnggota::get_history_dc_member($this->no_rekening, 'C', $from_date);
            $get_debet = KopTrxAnggota::get_history_dc_member($this->no_rekening, 'D', $from_date);
            $get_pinbuk = KopTrxAnggota::get_pinbuk_member($this->no_anggota, [43, 44], $from_date);

            $credit = (isset($get_credit->amount) ? $get_credit->amount : 0);
            $debet = (isset($get_debet->amount) ? $get_debet->amount : 0);
            $pinbuk = (isset($get_pinbuk->amount) ? $get_pinbuk->amount : 0);

            $saldo_awal = $credit - ($debet + $pinbuk);
            $saldo_akhir = $saldo_awal;

            $show = KopTrxAnggota::get_history_savingplan($this->no_rekening, $from_date, $thru_date);
            $show_pinbuk = KopTrxAnggota::get_history_member($this->no_anggota, [43, 44], $from_date, $thru_date);

            for ($j = 0; $j < count($show_pinbuk); $j++) {
                $saldo_akhir += 0 - $show_pinbuk[$j]->amount;

                $data[] = array(
                    'trx_date' => $show_pinbuk[$j]->trx_date,
                    'setor' => 0,
                    'tarik' => (int) $show_pinbuk[$j]->amount,
                    'saldo_akhir' => (int) $saldo_akhir,
                    'keterangan' => $show_pinbuk[$j]->description
                );
            }
        } else {
            // Simpanan Wajib / Minggon
            $get_credit = KopTrxAnggota::get_credit_member($this->no_anggota, [12, 34], $from_date);
            $get_debet = 0;
            $get_pinbuk = KopTrxAnggota::get_pinbuk_member($this->no_anggota, [42], $from_date);

            $credit = (isset($get_credit->amount) ? $get_credit->amount : 0);
            $debet = 0;
            $pinbuk = (isset($get_pinbuk->amount) ? $get_pinbuk->amount : 0);

            $saldo_awal = ($credit) - ($debet + $pinbuk);
            $saldo_akhir = $saldo_awal;

            $show = KopTrxAnggota::get_history_member($this->no_anggota, [12, 34, 42], $from_date, $thru_date);
        }

        for ($i = 0; $i < count($show); $i++) {
            $trx_date = $show[$i]->trx_date;
            $amount = $show[$i]->amount;
            $flag_debet_credit = $show[$i]->flag_debet_credit;
            $description = $show[$i]->description;
            $trx_type = $show[$i]->trx_type;

            if ($this->jenis_tabungan == 1) {
                if ($trx_type == 41 or $trx_type == 42 or $trx_type == 43 or $trx_type == 44) {
                    $flag_debet_credit = 'C';
                }
            }

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

        /*
        echo '<pre>';
        print_r($data);
        echo '</pre>';
        die;
        */

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
