<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KopPar extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'kop_par';
}
