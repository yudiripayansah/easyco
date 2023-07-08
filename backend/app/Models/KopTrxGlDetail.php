<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class KopTrxGlDetail extends Model
{
    use HasFactory;

    protected $table = 'kop_trx_gl_detail';
    protected $fillable = ['id_trx_gl_detail', 'id_trx_gl', 'kode_gl', 'flag_dc'];

    function get_ledger_detail($id_trx_gl)
    {
        $show = KopTrxGlDetail::select('kop_trx_gl_detail.*', 'kg.nama_gl')
            ->join('kop_gl AS kg', 'kg.kode_gl', 'kop_trx_gl_detail.kode_gl')
            ->where('id_trx_gl', $id_trx_gl)
            ->orderBy('trx_sequence')
            ->get();

        return $show;
    }

    function get_detail_inquiry($kode_cabang, $kode_gl, $from, $thru)
    {
        $show = KopTrxGlDetail::select('b.id_trx_gl', 'kop_trx_gl_detail.kode_gl', 'kop_trx_gl_detail.flag_dc', 'kop_trx_gl_detail.amount', 'b.voucher_date', DB::raw("(CASE WHEN kop_trx_gl_detail.flag_dc = 'C' THEN kop_trx_gl_detail.amount ELSE 0 END) AS credit"), DB::raw("(CASE WHEN kop_trx_gl_detail.flag_dc = 'D' THEN kop_trx_gl_detail.amount ELSE 0 END) AS debet"), 'c.default_saldo', 'b.description')
            ->join('kop_trx_gl AS b', 'b.id_trx_gl', 'kop_trx_gl_detail.id_trx_gl')
            ->join('kop_gl AS c', 'c.kode_gl', 'kop_trx_gl_detail.kode_gl')
            ->where('b.kode_cabang', $kode_cabang)
            ->where('kop_trx_gl_detail.kode_gl', $kode_gl)
            ->whereBetween('b.voucher_date', [$from, $thru])
            ->orderBy('b.voucher_date', 'ASC')
            ->orderBy('b.created_at', 'ASC')
            ->orderBy('kop_trx_gl_detail.trx_sequence', 'ASC')
            ->get();

        return $show;
    }
}
