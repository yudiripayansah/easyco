<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KopAnggotaUk extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'kop_anggota_uk';
}
