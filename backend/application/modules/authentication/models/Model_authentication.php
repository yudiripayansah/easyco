<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_authentication extends CI_Model {

    function __construct(){
        parent::__construct();
    }

    function getloginbypass($username,$password){
        $sql = "SELECT
        ku.id_user,
        ku.id_group,
        ku.nama_user,
        ku.photo,
        kc.kode_cabang,
        kc.nama_cabang,
        kp.nama_pgw,
        kp.jabatan,
        kp.email
        FROM kop_user AS ku
        JOIN kop_cabang AS kc ON kc.kode_cabang = ku.kode_cabang
        JOIN kop_pegawai AS kp ON kp.kode_pgw = ku.kode_pgw
        WHERE nama_user = ? AND password = ?";

        $param = array($username,$password);

        $query = $this->db->query($sql,$param);

        return $query->row_array();
    }

    function getemail($email){
        $sql = "SELECT id,email FROM mst_user WHERE email = ?";

        $param = array($email);

        $query = $this->db->query($sql,$param);

        return $query;
    }

    function getProfile($iduser){
        $sql = "SELECT * FROM mst_user_profile WHERE iduser = ?";

        $param = array($iduser);

        $query = $this->db->query($sql,$param);

        return $query->row_array();
    }

    function check_email_exist($email){
        $sql = "SELECT COUNT(*) AS jumlah FROM membership WHERE email = ?";

        $param = array($email);

        $query = $this->db->query($sql,$param);

        return $query->row_array();
    }

    function check_referal_exist($referal){
        $sql = "SELECT COUNT(*) AS jumlah FROM membership WHERE kode_referal = ?";

        $param = array($referal);

        $query = $this->db->query($sql,$param);

        return $query->row_array();
    }

    function check_phone_exist($nomor_hape){
        $sql = "SELECT COUNT(*) AS jumlah FROM membership WHERE nomor_hape = ?";

        $param = array($nomor_hape);

        $query = $this->db->query($sql,$param);

        return $query->row_array();
    }

    function check_nik_exist($nik){
        $sql = "SELECT COUNT(*) AS jumlah FROM membership WHERE nik = ?";

        $param = array($nik);

        $query = $this->db->query($sql,$param);

        return $query->row_array();
    }

    function check_order_code($kode_pesanan){
        $sql = "SELECT COUNT(*) AS jumlah FROM pesanan WHERE kode_pesanan = ?";

        $param = array($kode_pesanan);

        $query = $this->db->query($sql,$param);

        return $query->row_array();
    }

    function get_next_kode_member_first(){
        $sql = "SELECT CAST(RIGHT(SUBSTRING_INDEX(kode_member,'_',1),4) AS UNSIGNED) AS urut_member FROM membership GROUP BY CAST(RIGHT(SUBSTRING_INDEX(kode_member,'_',1),4) AS UNSIGNED) ORDER BY CAST(RIGHT(SUBSTRING_INDEX(kode_member,'_',1),4) AS UNSIGNED) DESC LIMIT 1";

        $query = $this->db->query($sql);

        return $query->row_array();
    }

    function get_pin_by_kode_paket($kode_paket){
        $sql = "SELECT jumlah_pin FROM paket WHERE kode_paket = ?";

        $param = array($kode_paket);

        $query = $this->db->query($sql,$param);

        return $query->row_array();
    }
}
