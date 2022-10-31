<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;
use Firebase\JWT\JWT;

class Api extends RestController{
    function __construct(){
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
    }

    function example_get(){
        $res = [
            'status' => true,
            'msg' => 'contoh api get'
        ];

        $this->response($res, 200);
    }

    function example_put(){
        $res = [
            'status' => true,
            'msg' => 'contoh api put'
        ];

        $this->response($res, 200);
    }

    function example_delete(){
        $res = [
            'status' => true,
            'msg' => 'contoh api delete'
        ];

        $this->response($res, 200);
    }

    function example_patch(){
        $res = [
            'status' => true,
            'msg' => 'contoh api patch'
        ];

        $this->response($res, 200);
    }
}
