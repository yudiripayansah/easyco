<?php
defined('BASEPATH') or exit('No direct script access allowed');
use chriskacerguis\RestServer\RestController;
use Firebase\JWT\JWT;

class Auth extends RestController
{
    public function __construct()
    {
        // Construct the parent class
        parent::__construct();
    }
    public function login_post()
    {
        $username = $this->input->post('username');
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        if (($username == 'admin' || $email == 'admin') && $password == 'admin') {
            $token = $this->generate_token();
            $res = [
                'status' => true,
                'msg' => 'Login berhasil anda akan dialihkan ke halaman Dashboard',
                'data' => $token[1],
                'token' => $token[0]
            ];
        } else {
            $res = [
                'status' => false,
                'msg' => 'Login gagal, Username dan Password salah',
                'data' => [
                    'username' => $username,
                    'password' => $password,
                    'input' => $this->input->post()
                ]
            ];
        }
        $this->response($res, 200);
    }
    public function generate_token()
    {
        $key = getenv('JWT_SECRET');
        $payload = array(
            'id' => '1',
            'username' => 'Superadmin',
            'name' => 'Superadmin',
            'email' => 'superadmin@easyco.co',
            'phone' => '081234567890',
            'role' => 'Admin',
            'img' => 'media/users/default.jpg',
        );
        $jwt = JWT::encode($payload, $key);
        $decoded = JWT::decode($jwt, $key, array('HS256'));
        return [$jwt,$decoded];
    }
    public function example_post()
    {
        $res = [
            'status' => true,
            'msg' => 'contoh api post'
        ];
        $this->response($res, 200);
    }
    public function example_get()
    {
        $res = [
            'status' => true,
            'msg' => 'contoh api get'
        ];
        $this->response($res, 200);
    }
    public function example_put()
    {
        $res = [
            'status' => true,
            'msg' => 'contoh api put'
        ];
        $this->response($res, 200);
    }
    public function example_delete()
    {
        $res = [
            'status' => true,
            'msg' => 'contoh api delete'
        ];
        $this->response($res, 200);
    }
    public function example_patch()
    {
        $res = [
            'status' => true,
            'msg' => 'contoh api patch'
        ];
        $this->response($res, 200);
    }
}
