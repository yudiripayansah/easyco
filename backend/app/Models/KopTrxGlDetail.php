<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
