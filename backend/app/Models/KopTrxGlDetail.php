<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KopTrxGlDetail extends Model
{
    use HasFactory;

    protected $table = 'kop_trx_gl_detail';
    protected $fillable = ['id_trx_gl_detail', 'id_trx_gl', 'kode_gl', 'flag_dc'];
}
