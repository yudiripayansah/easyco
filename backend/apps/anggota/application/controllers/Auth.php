<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;
use Firebase\JWT\JWT;

class Auth extends RestController
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('model_auth');
        date_default_timezone_set('Asia/Jakarta');
    }

    function generate_token($id_anggota, $no_anggota)
    {
        $key = getenv('JWT_SECRET');

        $payload = array(
            'id_anggota' => $id_anggota,
            'password' => $no_anggota
        );

        $jwt = JWT::encode($payload, $key);

        $decoded = JWT::decode($jwt, $key, array('HS256'));

        return [$jwt, $decoded];
    }

    function index_get()
    {
        echo 'Test API Sukses';
    }

    function check_username_post()
    {
        $id_user = $this->input->post('id_user');

        $check = $this->model_auth->check_username($id_user);

        $count = count($check);

        if ($count > 0) {
            $userAccount = array(
                'id_user' => $check['id_user'],
                'tipe_user' => $check['tipe_user']
            );

            $res = [
                'status' => TRUE,
                'msg' => 'Silakkan masukkan Password Anda',
                'data' => $userAccount,
                'token' => NULL
            ];
        } else {
            $check = $this->model_auth->check_member($id_user);

            $count = count($check);

            if ($count > 0) {
                if ($check['status'] <> 3) {
                    $data = array(
                        'id_user' => $check['noanggota'],
                        'tipe_user' => 1
                    );

                    $insert = $this->model_auth->insert('kis_user', $data);

                    if ($insert === TRUE) {
                        $userAccount = array(
                            'id_user' => $check['noanggota'],
                            'tipe_user' => 1
                        );

                        $res = [
                            'status' => TRUE,
                            'msg' => 'Silakkan masukkan Password Anda',
                            'data' => $userAccount,
                            'token' => NULL
                        ];
                    } else {
                        $res = [
                            'status' => FALSE,
                            'msg' => 'Maaf! Login tidak berhasil',
                            'data' => $this->input->post(),
                            'token' => NULL
                        ];
                    }
                } else {
                    $res = [
                        'status' => FALSE,
                        'msg' => 'Maaf! Login tidak berhasil. Anda sudah dikeluarkan dari Keanggotaan',
                        'data' => $this->input->post(),
                        'token' => NULL
                    ];
                }
            } else {
                $res = [
                    'status' => FALSE,
                    'msg' => 'Maaf! Akun Anda tidak ditemukan',
                    'data' => $this->input->post(),
                    'token' => NULL
                ];
            }
        }

        $this->response($res, 200);
    }

    function check_password_post()
    {
        $id_user = $this->input->post('id_user');
        $tipe_user = $this->input->post('tipe_user');
        $word = $this->input->post('password');

        $last_login = date('Y-m-d H:i:s');

        $berkah = 'Semoga Allah melindungi sistem ini dari serangan orang-orang yang tidak bertanggung jawab. Aamiin Allahumma Aamiin';

        $password = sha1($berkah . $word);

        $check = $this->model_auth->check_username($id_user);

        $token = $this->generate_token($id_user, $password, $tipe_user, $last_login);

        if ($check['password'] == $password) {
            $data = array(
                'last_login' => $last_login,
                'token' => $token[0]
            );

            $param = array('id_user' => $id_user);

            $update = $this->model_auth->update('kis_user', $data, $param);

            if ($update === TRUE) {
                $userAccount = array(
                    'id_user' => $id_user,
                    'tipe_user' => $tipe_user,
                    'last_login' => $last_login
                );

                $res = [
                    'status' => TRUE,
                    'msg' => 'Login Berhasil! Anda akan dialihkan ke halaman Dashboard',
                    'data' => $userAccount,
                    'token' => $token[0]
                ];
            } else {
                $res = [
                    'status' => FALSE,
                    'msg' => 'Maaf! Login tidak berhasil',
                    'data' => ['input' => $this->input->post()],
                    'token' => NULL
                ];
            }
        } else {
            if ($check['password'] == null) {
                $data = array(
                    'password' => $password,
                    'last_login' => $last_login,
                    'token' => $token[0]
                );

                $param = array('id_user' => $id_user);

                $update = $this->model_auth->update('kis_user', $data, $param);

                if ($update === TRUE) {
                    $userAccount = array(
                        'id_user' => $id_user,
                        'tipe_user' => $tipe_user,
                        'last_login' => $last_login
                    );

                    $res = [
                        'status' => TRUE,
                        'msg' => 'Login Berhasil! Anda akan dialihkan ke halaman Dashboard',
                        'data' => $userAccount,
                        'token' => $token[0]
                    ];
                } else {
                    $res = [
                        'status' => FALSE,
                        'msg' => 'Maaf! Login tidak berhasil',
                        'data' => ['input' => $this->input->post()],
                        'token' => NULL
                    ];
                }
            } else {
                $res = [
                    'status' => FALSE,
                    'msg' => 'Maaf! Password Anda salah',
                    'data' => $this->input->post(),
                    'token' => NULL
                ];
            }
        }

        $this->response($res, 200);
    }
}
