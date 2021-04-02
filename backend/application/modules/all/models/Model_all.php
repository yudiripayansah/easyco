<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_all extends CI_Model {

    function __construct(){
        parent::__construct();
    }

    function insert($table,$data,$DBCore){
        $DBCore->insert($table,$data);
    }

    function insert_batch($table,$data,$DBCore){
		$DBCore->insert_batch($table,$data);
    }

    function show_menu($isactive,$idgroup){
        $sql = "SELECT
        km.*
        FROM kop_menu AS km
        JOIN kop_role AS kr ON kr.id_menu = km.id_menu AND kr.id_group = ?
        WHERE km.status_menu = ?
        ORDER BY km.posisi ASC";

        $param = array($idgroup,$isactive);

        $query = $this->db->query($sql,$param);

        return $query->result_array();
    }

    function show_privilleges($isactive,$idgroup,$control){
        $sql = "SELECT
        COUNT(*) AS jumlah
        FROM mst_menu AS menu
        JOIN mst_role AS role ON (role.idmenu = menu.id AND role.idgroup = ?)
        WHERE menu.isactive = ? AND menu.control = ?
        ORDER BY menu.position ASC";

        $param = array($idgroup,$isactive,$control);

        $query = $this->db->query($sql,$param);

        return $query->row_array();
    }

    function show_group($isactive){
        $sql = "SELECT * FROM mst_group WHERE isactive = ? ORDER BY `group`";

        $param = array($isactive);

        $query = $this->db->query($sql,$param);

        return $query->result_array();
    }

    function update($table,$data,$param,$id,$DBCore){
        $DBCore->where($param,$id);
    	$DBCore->update($table,$data);
    }

    function update2($table,$data,$param,$DBCore){
        $DBCore->update($table,$data,$param);
    }

    function update_batch($table,$data,$param,$DBCore){
        $DBCore->update_batch($table,$data,$param);
    }

    function update_sortable($table,$data,$id){
        $this->db->update($table,$data,$id);
    }

    function delete($table,$param,$id,$DBCore){
        $DBCore->where($param, $id);
        $DBCore->delete($table);
    }

    function getSubUri($url){
        $sql = "SELECT subparent FROM kop_menu WHERE url_link = ?";

        $param = array($url);

        $query = $this->db->query($sql,$param);

        return $query->row_array();
    }
}
