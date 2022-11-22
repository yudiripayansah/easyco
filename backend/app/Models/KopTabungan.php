<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KopTabungan extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'kop_tabungan';
    protected $fillable = ['no_anggota', 'no_rekening', 'tanggal_buka', 'created_by'];

    function tpl_saving($no_anggota)
    {
        $show = KopTabungan::select('kpt.nama_produk', 'kop_tabungan.no_rekening', 'kop_tabungan.setoran')
            ->join('kop_prd_tabungan AS kpt', 'kpt.kode_produk', '=', 'kop_tabungan.kode_produk')
            ->where('kop_tabungan.status_rekening', 1)
            ->where('kpt.jenis_tabungan', 1)
            ->where('kop_tabungan.no_anggota', $no_anggota)
            ->get();

        return $show;
    }
}
