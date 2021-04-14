<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EASY_Controller extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('all/model_all');
        date_default_timezone_set('Asia/Jakarta');
    }

    function coreDB(){
        $db = $this->db;

        return $db;
    }

    function current_now(){
        $day = date('N');
        $date = date('d');
        $month = date('F');
        $year = date('Y');
        $time = date('H:i:s');

        if($day == '1'){
            $hari = 'Senin';
        } else if($day == '2'){
            $hari = 'Selasa';
        } else if($day == '3'){
            $hari = 'Rabu';
        } else if($day == '4'){
            $hari = 'Kamis';
        } else if($day == '5'){
            $hari = "Jum'at";
        } else if($day == '6'){
            $hari = 'Sabtu';
        } else {
            $hari = 'Minggu';
        }

        if($month == 'January'){
            $bulan = 'Januari';
        } else if($month == 'February'){
            $bulan = 'Februari';
        } else if($month == 'March'){
            $bulan = 'Maret';
        } else if($month == 'April'){
            $bulan = 'April';
        } else if($month == 'May'){
            $bulan = 'Mei';
        } else if($month == 'June'){
            $bulan = 'Juni';
        } else if($month == 'July'){
            $bulan = 'Juli';
        } else if($month == 'August'){
            $bulan = 'Agustus';
        } else if($month == 'September'){
            $bulan = 'September';
        } else if($month == 'October'){
            $bulan = 'Oktober';
        } else if($month == 'November'){
            $bulan = 'Nopember';
        } else {
            $bulan = 'Desember';
        }

        $waktu_tanggal = $hari.', '.$date.' '.$bulan.' '.$year.' - '.$time;

        return $waktu_tanggal;
    }

    function insert($table,$data,$DBCore){
    	$insert = $this->model_all->insert($table,$data,$DBCore);
    }

    function insert_batch($table,$data,$DBCore){
        $insert = $this->model_all->insert_batch($table,$data,$DBCore);
    }

    function update($table,$data,$param,$id,$DBCore){
    	$update = $this->model_all->update($table,$data,$param,$id,$DBCore);
    }

    function update2($table,$data,$param,$DBCore){
        $update = $this->model_all->update2($table,$data,$param,$DBCore);
    }

    function update_batch($table,$data,$param,$DBCore){
        $this->model_all->update_batch($table,$data,$param,$DBCore);
    }

    function update_sortable($table,$data,$id){
        $this->model_all->update_sortable($table,$data,$id);
    }

    function delete($table,$param,$id,$DBCore){
        $delete = $this->model_all->delete($table,$param,$id,$DBCore);
    }

    function show_menu($isactive){
        $idgroup = $this->session->userdata('id_group');
        $menu = $this->model_all->show_menu($isactive,$idgroup);

        return $menu;
    }

    function show_group($isactive){
        $group = $this->model_all->show_group($isactive);

        return $group;
    }

    function privilleges($control){
        $isactive = '1';
        $idgroup = $this->session->userdata('id_group');
        $priv = $this->model_all->show_privilleges($isactive,$idgroup,$control);

        $jumlah = $priv['jumlah'];

        return $jumlah;
    }

    function getJoinDate(){
        $joinDate = $this->session->userdata('input_date');
        $joinDate = substr($joinDate,0,7);
        $explode = explode('-',$joinDate);

        $year = $explode[0];
        $month = $explode[1];

        $joinDate = joinDate($month,$year);

        return $joinDate;
    }

    function getUri(){
        $uri1 = $this->uri->segment(1);
        $uri2 = $this->uri->segment(2);
        
        if($uri2){
            $uri = $uri1.'/'.$uri2;
        } else {
            $uri = $uri1;
        }

        return $uri;
    }

    function getSubUri($uri){
        $url = $this->model_all->getSubUri($uri);

        return $url;
    }
}
