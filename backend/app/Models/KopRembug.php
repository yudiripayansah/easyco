<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KopRembug extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'kop_rembug';
}