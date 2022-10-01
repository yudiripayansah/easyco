<?php

namespace App\Http\Controllers;

use App\Models\KopAuth;
use App\Models\KopUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }

    public function authentication(Request $request)
    {
        $data = $request->all();

        $data['last_login'] = date('Y-m-d H:i:s');

        $credentials = $request->only('nama_user', 'password');

        $token = JWTAuth::attempt($credentials);

        $validate = KopAuth::validateLogin($data);

        if ($validate['status'] == TRUE) {
            try {
                if ($token) {
                    $get = KopUser::select('*')->whereRaw("nama_user = '" . $data['nama_user'] . "' AND password = '" . Hash::make($data['password']) . "' AND status_user = '1'")->get();

                    $res = array(
                        'status' => TRUE,
                        'data' => $data,
                        'msg' => 'Berhasil!',
                        'Token' => $token,
                        'error' => NULL
                    );
                } else {
                    $res = array(
                        'status' => FALSE,
                        'data' => $data,
                        'msg' => 'Login credentials are invalid',
                        'Token' => NULL,
                        'error' => $validate['errors']
                    );
                }
            } catch (JWTException $e) {
                $res = array(
                    'status' => FALSE,
                    'data' => $data,
                    'msg' => $e->getMessage(),
                    'Token' => NULL,
                    'error' => $validate['errors']
                );
            }
        } else {
            $res = array(
                'status' => FALSE,
                'data' => $data,
                'msg' => $validate['msg'],
                'Token' => NULL,
                'error' => $validate['errors']
            );
        }

        $response = response()->json($res, 200);

        return $response;
    }
}
