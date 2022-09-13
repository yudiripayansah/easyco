<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    function get(Request $request)
    {
        $data = $request->all();

        print_r($data);
    }
}
