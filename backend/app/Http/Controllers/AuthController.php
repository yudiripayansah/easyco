<?php

namespace App\Http\Controllers;

use App\Models\KopAuth;
use App\Models\KopKasPetugas;
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
        $all = $request->all();

        $last_login = date('Y-m-d H:i:s');

        $all['last_login'] = $last_login;

        $credentials = $request->only('nama_user', 'password');

        $token = JWTAuth::attempt($credentials);

        $validate = KopAuth::validateLogin($all);

        if ($validate['status'] === TRUE) {
            try {
                if ($token) {
                    $param = array(
                        'nama_user' => $all['nama_user'],
                        'status_user' => 1
                    );

                    $get = KopUser::where($param)->first();

                    if ($get) {
                        $check = Hash::check($all['password'], $get->password);

                        if ($check) {
                            $check = KopUser::find($get->id);

                            $check->last_login = $last_login;
                            $check->token = $token;

                            $save = $check->save();

                            $param2 = array('id_user' => $get->id_user);

                            $get2 = KopKasPetugas::where($param2)->first();

                            $data = array(
                                'id' => $get->id,
                                'id_user' => $get->id_user,
                                'kode_cabang' => $get->kode_cabang,
                                'kode_pgw' => $get->kode_pgw,
                                'kode_petugas' => $get2->kode_petugas,
                                'nama_user' => $get->nama_user,
                                'role_user' => $get->role_user,
                                'akses_user' => $get->akses_user,
                                'status_user' => $get->status_user,
                                'photo' => $get->photo
                            );

                            if ($save) {
                                $res = array(
                                    'status' => TRUE,
                                    'data' => $data,
                                    'msg' => 'Berhasil!',
                                    'error' => NULL,
                                    'token' => $token
                                );
                            } else {
                                $res = array(
                                    'status' => FALSE,
                                    'data' => $all,
                                    'msg' => 'Maaf! Expired Token gagal diset',
                                    'error' => $validate['errors'],
                                    'token' => $token
                                );
                            }
                        } else {
                            $res = array(
                                'status' => FALSE,
                                'data' => $all,
                                'msg' => 'Maaf! Password masih salah',
                                'error' => $validate['errors'],
                                'token' => $token
                            );
                        }
                    } else {
                        $res = array(
                            'status' => FALSE,
                            'data' => $all,
                            'msg' => 'Maaf! Username tidak ditemukan',
                            'error' => $validate['errors'],
                            'token' => $token
                        );
                    }
                } else {
                    $res = array(
                        'status' => FALSE,
                        'data' => $all,
                        'msg' => 'Maaf! Login tidak berhasil',
                        'error' => $validate['errors'],
                        'token' => $token
                    );
                }
            } catch (JWTException $e) {
                $res = array(
                    'status' => FALSE,
                    'data' => $all,
                    'msg' => $e->getMessage(),
                    'error' => $validate['errors'],
                    'token' => $token
                );
            }
        } else {
            $res = array(
                'status' => FALSE,
                'data' => $all,
                'msg' => $validate['msg'],
                'error' => $validate['errors'],
                'token' => $token
            );
        }

        $response = response()->json($res, 200);

        return $response;
    }
}
