<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth {

    var $CI = null;

    function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->database();
    }

    function restrict($logged_out = FALSE) {
        if ($logged_out && $this->logged_in()) {
            redirect(base_url('dashboard'));
        }

        if (!$logged_out && !$this->logged_in()) {
            redirect(base_url('authentication'));
        }
    }

    function logged_in() {
        if ($this->CI->session->userdata('islogged') == FALSE) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
}
