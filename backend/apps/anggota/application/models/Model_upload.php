<?php

class Model_upload extends CI_Model
{

    function check_token($token)
    {
        $sql = "SELECT COUNT(*) AS cnt FROM kis_user WHERE token = ?";

        $param = array($token);

        $query = $this->db->query($sql, $param);

        return $query->row_array();
    }

    function check_expired($now, $token)
    {
        $sql = "SELECT (?::DATE - last_login::DATE) AS expired FROM kis_user WHERE token = ?";

        $param = array($now, $token);

        $query = $this->db->query($sql, $param);

        return $query->row_array();
    }

    function get_cif($noanggota)
    {
        $sql = "SELECT * FROM kis_anggota WHERE noanggota = ?";

        $param = array($noanggota);

        $query = $this->db->query($sql, $param);

        return $query->row_array();
    }

    function get_deposito($noanggota)
    {
        $sql = "SELECT COALESCE(SUM(saldo),0) AS saldo_deposito FROM kis_deposito WHERE status = '1' AND noanggota = ?";

        $param = array($noanggota);

        $query = $this->db->query($sql, $param);

        return $query->row_array();
    }

    function get_financing($noanggota)
    {
        $sql = "SELECT COALESCE(SUM(saldo_pkk+saldo_mgn),0) AS saldo_outstanding FROM kis_pembiayaan WHERE status = '1' AND noanggota = ?";

        $param = array($noanggota);

        $query = $this->db->query($sql, $param);

        return $query->row_array();
    }

    function delete($table)
    {
        $this->db->empty_table($table);
    }

    function insert_batch($table, $data)
    {
        $this->db->insert_batch($table, $data);
    }
}
