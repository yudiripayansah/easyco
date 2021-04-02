<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends EASY_Controller {

    function __construct(){
        parent::__construct();
        $this->auth->restrict();
        $this->load->model('model_dashboard');
        @date_default_timezone_set('Asia/Jakarta');
    }

    function index(){
        $data = array();

        $uri = $this->getUri();

        // MAIN PAGE
        $data['body'] = 'dashboard/vdashboard';
        $data['title'] = 'Beranda | EasyCo - Berkoperasi Itu Mudah';
        $data['f_title'] = 'Beranda';
        $data['s_title'] = 'Halaman Utama';

        // LIBRARY
        $data['csspage'] = 'dashboard/_css/csspage_dashboard';
        $data['jslib'] = 'dashboard/_js/jslib_dashboard';
        $data['jsscript'] = 'dashboard/_js/js_dashboard';

        $data['menu'] = $this->show_menu(1);
        $data['uri'] = $uri;
        $data['suburi'] = $this->getSubUri($uri);

        $this->load->vars($data);
        $this->load->view('view_dashboard');
    }
}
