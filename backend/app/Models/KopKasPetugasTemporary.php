<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KopKasPetugasTemporary extends Model
{
    use HasFactory;

    protected $table = 'kop_kas_petugas_temporary';

    function get_cash_history($kode_cabang, $tanggal, $created_by)
    {
        $show = KopKasPetugasTemporary::where('kode_cabang', $kode_cabang)
            ->where('trx_date', $tanggal)
            ->where('created_by', $created_by)
            ->get();

        return $show;
    }
}
