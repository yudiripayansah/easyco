<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Registration extends RestController
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('model_registration');
        date_default_timezone_set('Asia/Jakarta');
    }

    function create_user_post()
    {
        $id_user = $this->input->post('id_user');
        $pass = $this->input->post('password');

        $confirm = TRUE;

        $this->form_validation->set_rules('id_user', 'ID User', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $confirm = FALSE;

            $res = [
                'status' => FALSE,
                'msg' => validation_errors(),
                'data' => NULL
            ];
        }

        if ($confirm == TRUE) {
            $get_username = $this->model_registration->check_id_user($id_user);

            $jumlah = $get_username['jumlah'];

            if ($jumlah > 0) {
                $confirm = FALSE;

                $res = [
                    'status' => FALSE,
                    'msg' => 'ID User sudah terdaftar',
                    'data' => NULL
                ];
            }
        }

        if ($confirm == TRUE) {
            $berkah = 'Semoga Allah melindungi sistem ini dari serangan orang-orang yang tidak bertanggung jawab. Aamiin Allahumma Aamiin';

            $password = sha1($berkah . $pass);

            $data = array(
                'id_user' => $id_user,
                'tipe_user' => 2,
                'password' => $password
            );

            // DATABASE TRANSACTION
            $this->db->trans_begin();
            $this->model_registration->insert('kis_user', $data);

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();

                $res = [
                    'status' => TRUE,
                    'msg' => 'ID User berhasil ditambahkan',
                    'data' => $this->input->post()
                ];
            } else {
                $this->db->trans_rollback();

                $res = [
                    'status' => FALSE,
                    'msg' => 'ID User gagal ditambahkan',
                    'data' => $this->input->post()
                ];
            }
        }

        $this->response($res, 200);
    }

    function read_user_post()
    {
        $page = $this->input->post('page');
        $limit_rows = $this->input->post('limit_rows');
        $sidx = $this->input->post('sidx');
        $sord = $this->input->post('sord');
        $totalrows = $this->input->post('totalrows');
        $search_user = $this->input->post('search_user');

        if ($totalrows) {
            $limit_rows = $totalrows;
        }

        $sum = $this->model_registration->get_user('', '', '', '', $search_user);

        $count = count($sum);

        if ($count > 0) {
            $total_pages = ceil($count / $limit_rows);
        } else {
            $total_pages = 0;
        }

        if ($page > $total_pages) {
            $page = $total_pages;
        }

        $start = ($limit_rows * $page) - $limit_rows;

        if ($start < 0) {
            $start = 0;
        }

        $get = $this->model_registration->get_user($sidx, $sord, $limit_rows, $start, $search_user);

        $loop = array();

        foreach ($get as $gt) {
            $loop[] = array(
                'id' => $gt['id'],
                'id_user' => $gt['id_user'],
                'tipe_user' => $gt['tipe_user'],
                'last_login' => $gt['last_login']
            );
        }

        $data = array(
            'page' => $page,
            'total_pages' => $total_pages,
            'count' => $count,
            'jqgrid' => $loop
        );

        $res = [
            'status' => TRUE,
            'msg' => NULL,
            'data' => $data
        ];

        $this->response($res, 200);
    }

    function get_user_post()
    {
        $id_user = $this->input->post('id_user');

        $show = $this->model_registration->get_user_by_id($id_user);

        $id_user = $show['id_user'];
        $password = $show['password'];

        $data = array(
            'id_user' => $id_user,
            'password' => $password
        );

        $res = [
            'status' => FALSE,
            'msg' => NULL,
            'data' => $data
        ];

        $this->response($res, 200);
    }

    function update_user_post()
    {
        $id_user = $this->input->post('id_user');
        $pass = $this->input->post('password');
        $old_pass = $this->input->post('old_password');

        $confirm = TRUE;

        $this->form_validation->set_rules('id_user', 'ID User', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'trim');

        if ($this->form_validation->run() == FALSE) {
            $confirm = FALSE;

            $res = [
                'status' => FALSE,
                'msg' => validation_errors(),
                'data' => NULL
            ];
        }

        if ($confirm == TRUE) {
            if (!empty($pass)) {
                $berkah = 'Semoga Allah melindungi sistem ini dari serangan orang-orang yang tidak bertanggung jawab. Aamiin Allahumma Aamiin';

                $password = sha1($berkah . $pass);
            } else {
                $password = $old_pass;
            }

            $data = array('password' => $password);
            $param = array('id_user' => $id_user);

            // DATABASE TRANSACTION
            $this->db->trans_begin();
            $this->model_registration->update('kis_user', $data, $param);

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();

                $res = [
                    'status' => TRUE,
                    'msg' => 'Password berhasil diubah',
                    'data' => $this->input->post()
                ];
            } else {
                $this->db->trans_rollback();

                $res = [
                    'status' => FALSE,
                    'msg' => 'Password gagal diubah',
                    'data' => $this->input->post()
                ];
            }
        }

        $this->response($res, 200);
    }

    function delete_user_post()
    {
        $id_user = $this->input->post('id_user');

        $param = array('id_user' => $id_user);

        // DATABASE TRANSACTION
        $this->db->trans_begin();
        $this->model_registration->delete('kis_user', $param);

        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();

            $res = [
                'status' => TRUE,
                'msg' => 'User berhasil dihapus',
                'data' => $this->input->post()
            ];
        } else {
            $this->db->trans_rollback();

            $res = [
                'status' => FALSE,
                'msg' => 'User gagal dihapus',
                'data' => $this->input->post()
            ];
        }

        $this->response($res, 200);
    }
}
