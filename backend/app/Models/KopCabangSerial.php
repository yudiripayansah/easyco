<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KopCabangSerial extends Model
{
    use SoftDeletes;

    protected $table = 'kop_cabang_serial';
}
