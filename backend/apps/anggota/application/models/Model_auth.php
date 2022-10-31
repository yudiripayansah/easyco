<?php

class Model_auth extends CI_Model
{

	function insert($table, $data)
	{
		$this->db->trans_begin();
		$this->db->insert($table, $data);

		if ($this->db->trans_status() === TRUE) {
			$this->db->trans_commit();

			return TRUE;
		} else {
			$this->db->trans_rollback();

			return FALSE;
		}
	}

	function update($table, $data, $param)
	{
		$this->db->trans_begin();
		$this->db->update($table, $data, $param);

		if ($this->db->trans_status() === TRUE) {
			$this->db->trans_commit();

			return TRUE;
		} else {
			$this->db->trans_rollback();

			return FALSE;
		}
	}

	function check_username($id_user)
	{
		$sql = "SELECT * FROM kis_user WHERE id_user = ?";

		$param = array($id_user);

		$query = $this->db->query($sql, $param);

		return $query->row_array();
	}

	function check_member($id_user)
	{
		$sql = "SELECT * FROM kis_anggota WHERE noanggota = ?";

		$param = array($id_user);

		$query = $this->db->query($sql, $param);

		return $query->row_array();
	}
}
