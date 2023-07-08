<?php

namespace App\Exports;

use App\Models\KopCabang;
use App\Models\KopGl;
use App\Models\KopTrxGl;
use App\Models\KopTrxGlDetail;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class BukuBesarExport implements FromView
{
    use Exportable;

    protected $kode_cabang, $kode_gl, $from_date, $thru_date, $format;

    function __construct($kode_cabang, $kode_gl, $from_date, $thru_date, $format)
    {
        $this->kode_cabang = $kode_cabang;
        $this->kode_gl = $kode_gl;
        $this->from_date = $from_date;
        $this->thru_date = $thru_date;
        $this->format = $format;
    }

    function view(): View
    {
        $format = $this->format;

        $saldo_awal = KopTrxGl::get_saldo_awal($this->kode_gl, $this->from_date, $this->kode_cabang);
        $show = KopTrxGlDetail::get_detail_inquiry($this->kode_cabang, $this->kode_gl, $this->from_date, $this->thru_date);

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

        $gl = KopGl::where('kode_gl', $this->kode_gl)->first();

        $saldo_akhir = $saldo_awal[0]->saldo_awal;
        $total_debit = 0;
        $total_credit = 0;
        $i = 0;

        $jumlah = $show->count();

        for ($j = 0; $j <= $jumlah; $j++) {
            if ($j == 0) {
                $data[$j]['nomor'] = '';
                $data[$j]['trx_date'] = '';
                $data[$j]['description'] = 'Saldo Awal';
                $data[$j]['debet'] = 0;
                $data[$j]['credit'] = 0;
                $data[$j]['saldo_akhir'] = (int)$saldo_akhir;
                $data[$j]['id_trx_gl'] = '';
            } else {
                if ($show[$i]['flag_dc'] == 'C') {
                    if ($show[$i]['default_saldo'] == 'C') {
                        $saldo_akhir += $show[$i]['amount'];
                    } else {
                        $saldo_akhir -= $show[$i]['amount'];
                    }
                }

                if ($show[$i]['flag_dc'] == 'D') {
                    if ($show[$i]['default_saldo'] == 'D') {
                        $saldo_akhir += $show[$i]['amount'];
                    } else {
                        $saldo_akhir -= $show[$i]['amount'];
                    }
                }

                $data[$j]['nomor'] = $i + 1;
                $data[$j]['trx_date'] = date('d-m-Y', strtotime($show[$i]['voucher_date']));
                $data[$j]['description'] = $show[$i]['description'];
                $data[$j]['debet'] = (int)$show[$i]['debet'];
                $data[$j]['credit'] = (int)$show[$i]['credit'];
                $data[$j]['saldo_akhir'] = (int)$saldo_akhir;
                $data[$j]['id_trx_gl'] = $show[$i]['id_trx_gl'];

                $total_debit  += $show[$i]['debet'];
                $total_credit += $show[$i]['credit'];

                $i++;
            }

            $show->nama_cabang = $cabang;
            $show->kode_gl = $gl->nama_gl;
            $show->from_date = $this->from_date;
            $show->thru_date = $this->thru_date;
        }

        return view('bukubesar', [
            'format' => $format,
            'bukubesar' => $data,
            'jumlah' => $jumlah,
            'head' => $show
        ]);
    }
}
