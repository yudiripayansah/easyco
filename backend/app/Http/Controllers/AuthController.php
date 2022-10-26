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

        $last_login = date('Y-m-d H:i:s');

        $data['last_login'] = $last_login;

        $credentials = $request->only('nama_user', 'password');

        $token = JWTAuth::attempt($credentials);

        $validate = KopAuth::validateLogin($data);

        if ($validate['status'] === TRUE) {
            try {
                if ($token) {
                    $param = array(
                        'nama_user' => $data['nama_user'],
                        'status_user' => 1
                    );

                    $get = KopUser::where($param)->first();

                    if ($get) {
                        $check = Hash::check($data['password'], $get->password);

                        if ($check) {
                            $check = KopUser::find($get->id);

                            $check->last_login = $last_login;
                            $check->token = $token;

                            $save = $check->save();

                            if ($save) {
                                $res = array(
                                    'status' => TRUE,
                                    'data' => $get,
                                    'msg' => 'Berhasil!',
                                    'error' => NULL
                                );
                            } else {
                                $res = array(
                                    'status' => FALSE,
                                    'data' => $data,
                                    'msg' => 'Maaf! Expired Token gagal diset',
                                    'error' => $validate['errors']
                                );
                            }
                        } else {
                            $res = array(
                                'status' => FALSE,
                                'data' => $data,
                                'msg' => 'Maaf! Password masih salah',
                                'error' => $validate['errors']
                            );
                        }
                    } else {
                        $res = array(
                            'status' => FALSE,
                            'data' => $data,
                            'msg' => 'Maaf! Username tidak ditemukan',
                            'error' => $validate['errors']
                        );
                    }
                } else {
                    $res = array(
                        'status' => FALSE,
                        'data' => $data,
                        'msg' => 'Maaf! Login tidak berhasil',
                        'error' => $validate['errors']
                    );
                }
            } catch (JWTException $e) {
                $res = array(
                    'status' => FALSE,
                    'data' => $data,
                    'msg' => $e->getMessage(),
                    'error' => $validate['errors']
                );
            }
        } else {
            $res = array(
                'status' => FALSE,
                'data' => $data,
                'msg' => $validate['msg'],
                'error' => $validate['errors']
            );
        }

        $response = response()->json($res, 200);

        return $response;
    }
}
