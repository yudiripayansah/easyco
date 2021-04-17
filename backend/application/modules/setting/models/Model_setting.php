<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_setting extends CI_Model {

    function __construct(){
        parent::__construct();
    }

    function read_group($sidx,$sord,$limit_rows,$start){
        $sql = "SELECT * FROM kop_group ";

        if($sidx != ''){
            $sql .= 'ORDER BY '.$sidx.' '.$sord.' ';
        }

        if($limit_rows != '' and $start != ''){
            $sql .= 'LIMIT '.$limit_rows.' OFFSET '.$start;
        }

        $query = $this->db->query($sql);

        return $query->result_array();
    }

    function read_user($sidx,$sord,$limit_rows,$start){
        $sql = "SELECT
        ku.id_user,
        kg.nama_grup,
        ku.nama_user,
        kc.nama_cabang,
        kp.nama_pgw,
        ku.photo,
        ku.status_user
        FROM kop_user AS ku
        JOIN kop_group AS kg ON kg.id_group = ku.id_group
        JOIN kop_cabang AS kc ON kc.kode_cabang = ku.kode_cabang
        JOIN kop_pegawai AS kp ON kp.kode_pgw = ku.kode_pgw ";

        if($sidx != ''){
            $sql .= 'ORDER BY '.$sidx.' '.$sord.' ';
        }

        if($limit_rows != '' and $start != ''){
            $sql .= 'LIMIT '.$limit_rows.' OFFSET '.$start;
        }


        $query = $this->db->query($sql);

        return $query->result_array();
    }

    function apimenu($sidx,$sord,$limit_rows,$start){
        $sql = "SELECT
        mm.id,
        mm.menu,
        mm.control,
        (SELECT menu FROM mst_menu WHERE parent = mm.subparent) AS subparent,
        mm.isactive
        FROM mst_menu AS mm ";

        if($sidx != ''){
            $sql .= 'ORDER BY '.$sidx.' '.$sord.' ';
        }

        if($limit_rows != '' and $start != ''){
            $sql .= 'LIMIT '.$limit_rows.' OFFSET '.$start;
        }


        $query = $this->db->query($sql);

        return $query->result_array();
    }

    function get_all_branch(){
        $sql = "SELECT branch_code, branch_name FROM branch WHERE branch_code <> '00000' AND branch_class = '1' AND isactive = '1' ORDER BY branch_code";

        $query = $this->db->query($sql);

        return $query->result_array();
    }

    function get_all_branch_by_class(){
        $sql = "SELECT branch_code, branch_parent, branch_name FROM branch WHERE branch_class = '2' AND isactive = '1' ORDER BY branch_code";

        $query = $this->db->query($sql);

        return $query->result_array();
    }

    function get_branch_by_branch_code($branch_parent){
        $sql = "SELECT * FROM branch WHERE branch_code = ?";

        $param = array($branch_parent);

        $query = $this->db->query($sql,$param);

        return $query->row_array();
    }

    function get_branch_by_id($id){
        $sql = "SELECT * FROM branch WHERE id = ?";

        $param = array($id);

        $query = $this->db->query($sql,$param);

        return $query->row_array();
    }

    function get_group_by_id($id){
        $sql = "SELECT * FROM kop_group WHERE id_group = ?";

        $param = array($id);

        $query = $this->db->query($sql,$param);

        return $query->row_array();
    }

    function get_group_by_group($group){
        $sql = "SELECT COUNT(*) AS jumlah FROM kop_group WHERE nama_grup = ?";

        $param = array($group);

        $query = $this->db->query($sql,$param);

        return $query->row_array();
    }

    function get_user_by_id($id){
        $sql = "SELECT * FROM mst_user WHERE id = ?";

        $param = array($id);

        $query = $this->db->query($sql,$param);

        return $query->row_array();
    }

    function get_holiday_by_id($id){
        $sql = "SELECT * FROM holiday WHERE id = ?";

        $param = array($id);

        $query = $this->db->query($sql,$param);

        return $query->row_array();
    }

    function get_user_by_username($username){
        $sql = "SELECT COUNT(*) AS jumlah FROM kop_user WHERE nama_user = ?";

        $param = array($username);

        $query = $this->db->query($sql,$param);

        return $query->row_array();
    }

    function get_holiday_by_date($holiday){
        $sql = "SELECT COUNT(*) AS jumlah FROM holiday WHERE holiday_date = ?";

        $param = array($holiday);

        $query = $this->db->query($sql,$param);

        return $query->row_array();
    }

    function get_menu_by_id($id){
        $sql = "SELECT * FROM mst_menu WHERE id = ?";

        $param = array($id);

        $query = $this->db->query($sql,$param);

        return $query->row_array();
    }

    function get_menu(){
        $sql = "SELECT * FROM mst_menu WHERE subparent = '0' AND isactive = '1' ORDER BY parent";

        $query = $this->db->query($sql);

        return $query->result_array();
    }

    function get_category(){
        $sql = "SELECT * FROM mst_menu WHERE isactive = '1' ORDER BY position";

        $query = $this->db->query($sql);

        return $query->result_array();
    }

    function get_menu_by_menu($menu){
        $sql = "SELECT COUNT(*) AS jumlah FROM mst_menu WHERE menu = ?";

        $param = array($menu);

        $query = $this->db->query($sql,$param);

        return $query->row_array();
    }

    function get_menu_by_parent($parent){
        $sql = "SELECT * FROM mst_menu WHERE subparent = ? AND isactive = '1' ORDER BY parent";

        $param = array($parent);

        $query = $this->db->query($sql,$param);

        return $query->result_array();
    }

    function get_menu_by_sub_parent($parent){
        $sql = "SELECT * FROM mst_menu WHERE subparent = ? AND isactive = '1' ORDER BY parent";

        $param = array($parent);

        $query = $this->db->query($sql,$param);

        return $query->result_array();
    }

    function get_max_position($parent){
        $sql = "SELECT MAX(position) AS max FROM mst_menu WHERE subparent = ?";

        $param = array($parent);

        $query = $this->db->query($sql,$param);

        return $query->row_array();
    }

    function get_count_category($parent){
        $sql = "SELECT COUNT(*) AS total FROM mst_menu WHERE subparent = ?";

        $param = array($parent);

        $query = $this->db->query($sql,$param);

        return $query->row_array();
    }

    function getParent($id){
        $sql = "SELECT parent FROM mst_menu WHERE id = ?";

        $param = array($id);

        $query = $this->db->query($sql,$param);

        return $query->result_array();
    }

    function getSub($parent){
        $sql = "SELECT parent FROM mst_menu WHERE subparent = ?";

        $param = array($parent);

        $query = $this->db->query($sql,$param);

        return $query->result_array();
    }

    function get_role_by_foreign($id){
        $sql = "SELECT
        role.*,
        menu.id,
        menu.menu,
        menu.flag,
        menu.parent,
        menu.subparent,
        menu.control
        FROM mst_menu AS menu
        LEFT JOIN mst_role AS role ON (role.idmenu = menu.id AND role.idgroup = ?)
        ORDER BY menu.position";

        $param = array($id);

        $query = $this->db->query($sql,$param);

        return $query->result_array();
    }
}
