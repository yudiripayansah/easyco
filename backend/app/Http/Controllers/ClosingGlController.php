<?php

namespace App\Http\Controllers;

use App\Models\KopClosingGl;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClosingGlController extends Controller
{
    function get_closing_date()
    {
        $get = KopClosingGl::get_closing_date();

        $data = array();

        foreach ($get as $gt) {
            $data[] = array('thru_date_closing' => $gt['thru_date_closing']);
        }

        $res = array(
            'status' => true,
            'data' => $data
        );

        $response = response()->json($res, 200);

        return $response;
    }
}
