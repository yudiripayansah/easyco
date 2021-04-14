<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notfound extends EASY_Controller {

    function __construct(){
        parent::__construct();
        $this->auth->restrict();
    }

    function index(){
        $data = array();

        // MAIN PAGE
        $data['title'] = 'Oops! Halaman tidak ditemukan';
        $data['f_title'] = 'Oops!';
        $data['s_title'] = 'Anda tidak diizinkan mengakses halaman ini';

        $this->load->vars($data);
        $this->load->view('notfound/vnotfound');
    }
}
