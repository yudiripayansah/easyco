<?php

class Model_registration extends CI_Model
{

    function get_user($sidx, $sord, $limit_rows, $start, $search)
    {
        $param = array();

        $sql = "SELECT * FROM kis_user WHERE tipe_user = 2 AND id_user LIKE ? ";

        $param[] = '%' . $search . '%';

        if ($sidx != '') {
            $sql .= 'ORDER BY ' . $sidx . ' ' . $sord . ' ';
        }

        if ($limit_rows != '' and $start != '') {
            $sql .= 'LIMIT ' . $limit_rows . ' OFFSET ' . $start;
        }

        $query = $this->db->query($sql, $param);

        return $query->result_array();
    }

    function check_id_user($id_user)
    {
        $sql = "SELECT COUNT(*) AS jumlah FROM kis_user WHERE id_user = ?";

        $param = array($id_user);

        $query = $this->db->query($sql, $param);

        return $query->row_array();
    }

    function get_user_by_id($id_user)
    {
        $sql = "SELECT * FROM kis_user WHERE id_user = ?";

        $param = array($id_user);

        $query = $this->db->query($sql, $param);

        return $query->row_array();
    }

    function insert($table, $data)
    {
        $this->db->insert($table, $data);
    }

    function update($table, $data, $param)
    {
        $this->db->update($table, $data, $param);
    }

    function delete($table, $param)
    {
        $this->db->delete($table, $param);
    }
}
