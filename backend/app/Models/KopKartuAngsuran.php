<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KopKartuAngsuran extends Model
{
    use HasFactory;

    protected $table = 'kop_kartu_angsuran';

    function get_history_financing($no_rekening)
    {
        $show = KopKartuAngsuran::select('tgl_angsuran', 'tgl_bayar', 'angsuran_ke', 'angsuran_pokok', 'angsuran_margin', 'saldo_pokok', 'saldo_margin')
            ->where('no_rekening', $no_rekening)
            ->orderBy('angsuran_ke', 'ASC')
            ->get();

        return $show;
    }
}
