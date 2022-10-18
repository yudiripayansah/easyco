<?php

namespace App\Http\Controllers;

use App\Models\KopCabang;
use App\Models\KopUser;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CabangController extends Controller
{
    protected $user;

    public function create(Request $request)
    {
        $token = $request->header('token');

        $data = $request->all();

        $now = date('Y-m-d');

        if ($token) {
            $check_token = KopUser::where('token', $token)->first();

            if ($check_token) {
                $from_date = date('Y-m-d', strtotime($check_token->last_login));
                $thru_date = $now;

                $date1 = new DateTime($from_date);
                $date2 = new DateTime($thru_date);

                $interval = $date1->diff($date2);

                $expired = $interval->format('%a');

                if ($expired > 7) {
                    $res = array(
                        'status' => FALSE,
                        'data' => $data,
                        'msg' => 'Token Expired',
                        'error' => NULL
                    );
                } else {
                    $validate = KopCabang::validateAdd($data);

                    DB::beginTransaction();

                    if ($validate['status'] == TRUE) {
                        try {
                            $create = KopCabang::create($data);
                            $id = KopCabang::find($create->id);

                            $res = array(
                                'status' => TRUE,
                                'data' => $id,
                                'msg' => 'Berhasil!',
                                'error' => NULL
                            );

                            DB::commit();
                        } catch (Exception $e) {
                            DB::rollBack();

                            $res = array(
                                'status' => FALSE,
                                'data' => $data,
                                'msg' => $e->getMessage(),
                                'error' => NULL
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
                }
            } else {
                $res = array(
                    'status' => FALSE,
                    'data' => $data,
                    'msg' => 'Token Invalid',
                    'error' => NULL
                );
            }
        } else {
            $res = array(
                'status' => FALSE,
                'data' => $data,
                'msg' => 'No Token Provided',
                'error' => NULL
            );
        }

        $response = response()->json($res, 200);

        return $response;
    }

    public function read(Request $request)
    {
        $token = $request->header('token');

        $now = date('Y-m-d');

        if ($token) {
            $check_token = KopUser::where('token', $token)->first();

            if ($check_token) {
                $from_date = date('Y-m-d', strtotime($check_token->last_login));
                $thru_date = $now;

                $date1 = new DateTime($from_date);
                $date2 = new DateTime($thru_date);

                $interval = $date1->diff($date2);

                $expired = $interval->format('%a');

                if ($expired > 7) {
                    $res = array(
                        'status' => FALSE,
                        'data' => $request->all(),
                        'msg' => 'Token Expired',
                        'error' => NULL
                    );
                } else {
                    $offset = 0;
                    $page = 1;
                    $perPage = '~';
                    $sortDir = 'ASC';
                    $sortBy = 'kode_cabang';
                    $search = NULL;
                    $total = 0;
                    $totalPage = 1;
                    $type = NULL;
                    $id_cabang = NULL;

                    if ($request->page) {
                        $page = $request->page;
                    }

                    if ($request->perPage) {
                        $perPage = $request->perPage;
                    }

                    if ($request->sortDir) {
                        $sortDir = $request->sortDir;
                    }

                    if ($request->sortBy) {
                        $sortBy = $request->sortBy;
                    }

                    if ($request->search) {
                        $search = $request->search;
                    }

                    if ($page > 1) {
                        $offset = ($page - 1) * $perPage;
                    }

                    $read = KopCabang::select('*')->orderBy($sortBy, $sortDir);

                    if ($perPage != '~') {
                        $read->skip($offset)->take($perPage);
                    }

                    if ($search != NULL) {
                        $read->whereRaw("(kode_cabang LIKE '%" . $search . "%' OR nama_cabang LIKE '%" . $search . "%')");
                    }

                    $read = $read->get();

                    foreach ($read as $rd) {
                        $useCount = 'used count diubah datanya disini';
                        $rd->used_count = $useCount;
                    }

                    if ($search || $id_cabang || $type) {
                        $total = KopCabang::orderBy($sortBy, $sortDir);

                        if ($search) {
                            $total->whereRaw("(kode_cabang LIKE '%" . $search . "%' OR nama_cabang LIKE '%" . $search . "%')");
                        }

                        $total = $total->count();
                    } else {
                        $total = KopCabang::all()->count();
                    }

                    if ($perPage != '~') {
                        $totalPage = ceil($total / $perPage);
                    }

                    $res = array(
                        'status' => true,
                        'data' => $read,
                        'page' => $page,
                        'perPage' => $perPage,
                        'sortDir' => $sortDir,
                        'sortBy' => $sortBy,
                        'search' => $search,
                        'total' => $total,
                        'totalPage' => $totalPage,
                        'msg' => 'List data available'
                    );
                }
            } else {
                $res = array(
                    'status' => FALSE,
                    'data' => $request->all(),
                    'msg' => 'Token Invalid',
                    'error' => NULL
                );
            }
        } else {
            $res = array(
                'status' => FALSE,
                'data' => $request->all(),
                'msg' => 'No Token Provided',
                'error' => NULL
            );
        }

        $response = response()->json($res, 200);

        return $response;
    }

    public function detail(Request $request)
    {
        $token = $request->header('token');

        $now = date('Y-m-d');

        if ($token) {
            $check_token = KopUser::where('token', $token)->first();

            if ($check_token) {
                $from_date = date('Y-m-d', strtotime($check_token->last_login));
                $thru_date = $now;

                $date1 = new DateTime($from_date);
                $date2 = new DateTime($thru_date);

                $interval = $date1->diff($date2);

                $expired = $interval->format('%a');

                if ($expired > 7) {
                    $res = array(
                        'status' => FALSE,
                        'data' => $request->all(),
                        'msg' => 'Token Expired',
                        'error' => NULL
                    );
                } else {
                    $id = $request->id;

                    if ($id) {
                        $get = KopCabang::find($id);

                        if ($get) {
                            $res = array(
                                'status' => TRUE,
                                'data' => $get,
                                'msg' => 'Berhasil!',
                                'error' => NULL
                            );
                        } else {
                            $res = array(
                                'status' => FALSE,
                                'data' => $request->all(),
                                'msg' => 'Maaf! Data tidak ditemukan',
                                'error' => NULL
                            );
                        }
                    } else {
                        $res = array(
                            'status' => FALSE,
                            'data' => $request->all(),
                            'msg' => 'Maaf! Cabang tidak bisa ditampilkan',
                            'error' => NULL
                        );
                    }
                }
            } else {
                $res = array(
                    'status' => FALSE,
                    'data' => $request->all(),
                    'msg' => 'Token Invalid',
                    'error' => NULL
                );
            }
        } else {
            $res = array(
                'status' => FALSE,
                'data' => $request->all(),
                'msg' => 'No Token Provided',
                'error' => NULL
            );
        }

        $response = response()->json($res, 200);

        return $response;
    }

    public function update(Request $request)
    {
        $token = $request->header('token');

        $now = date('Y-m-d');

        if ($token) {
            $check_token = KopUser::where('token', $token)->first();

            if ($check_token) {
                $from_date = date('Y-m-d', strtotime($check_token->last_login));
                $thru_date = $now;

                $date1 = new DateTime($from_date);
                $date2 = new DateTime($thru_date);

                $interval = $date1->diff($date2);

                $expired = $interval->format('%a');

                if ($expired > 7) {
                    $res = array(
                        'status' => FALSE,
                        'data' => $request->all(),
                        'msg' => 'Token Expired',
                        'error' => NULL
                    );
                } else {
                    $get = KopCabang::find($request->id);
                    $validate = KopCabang::validateUpdate($request->all());

                    $get->nama_cabang = $request->nama_cabang;
                    $get->pimpinan_cabang = $request->pimpinan_cabang;

                    DB::beginTransaction();

                    if ($validate['status'] == TRUE) {
                        try {
                            $get->save();

                            $res = array(
                                'status' => TRUE,
                                'data' => NULL,
                                'msg' => 'Berhasil!',
                                'error' => NULL
                            );

                            DB::commit();
                        } catch (Exception $e) {
                            DB::rollBack();

                            $res = array(
                                'status' => FALSE,
                                'data' => $request->all(),
                                'msg' => $e->getMessage(),
                                'error' => NULL
                            );
                        }
                    } else {
                        $res = array(
                            'status' => FALSE,
                            'data' => $request->all(),
                            'msg' => $validate['msg'],
                            'error' => $validate['errors']
                        );
                    }
                }
            } else {
                $res = array(
                    'status' => FALSE,
                    'data' => $request->all(),
                    'msg' => 'Token Invalid',
                    'error' => NULL
                );
            }
        } else {
            $res = array(
                'status' => FALSE,
                'data' => $request->all(),
                'msg' => 'No Token Provided',
                'error' => NULL
            );
        }

        $response = response()->json($res, 200);

        return $response;
    }

    public function delete(Request $request)
    {
        $token = $request->header('token');

        $now = date('Y-m-d');

        if ($token) {
            $check_token = KopUser::where('token', $token)->first();

            if ($check_token) {
                $from_date = date('Y-m-d', strtotime($check_token->last_login));
                $thru_date = $now;

                $date1 = new DateTime($from_date);
                $date2 = new DateTime($thru_date);

                $interval = $date1->diff($date2);

                $expired = $interval->format('%a');

                if ($expired > 7) {
                    $res = array(
                        'status' => FALSE,
                        'data' => $request->all(),
                        'msg' => 'Token Expired',
                        'error' => NULL
                    );
                } else {
                    $id = $request->id;

                    if ($id) {
                        $data = KopCabang::find($id);

                        try {
                            $data->delete();

                            $res = array(
                                'status' => true,
                                'data' => NULL,
                                'msg' => 'Berhasil!',
                                'error' => NULL
                            );
                        } catch (Exception $e) {
                            DB::rollBack();

                            $res = array(
                                'status' => FALSE,
                                'data' => $request->all(),
                                'msg' => $e->getMessage(),
                                'error' => NULL
                            );
                        }
                    } else {
                        $res = array(
                            'status' => FALSE,
                            'data' => $request->all(),
                            'msg' => 'Maaf! Cabang tidak ditemukan',
                            'error' => NULL
                        );
                    }
                }
            } else {
                $res = array(
                    'status' => FALSE,
                    'data' => $request->all(),
                    'msg' => 'Token Invalid',
                    'error' => NULL
                );
            }
        } else {
            $res = array(
                'status' => FALSE,
                'data' => $request->all(),
                'msg' => 'No Token Provided',
                'error' => NULL
            );
        }

        $response = response()->json($res, 200);

        return $response;
    }
}
