<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KopClosingGl extends Model
{
    use SoftDeletes;

    protected $table = 'kop_closing_gl';

    function get_closing_date()
    {
        $show = KopClosingGl::select('thru_date_closing')->groupBy('thru_date_closing')->orderBy('thru_date_closing')->get();

        return $show;
    }
}
