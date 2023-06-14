<?php

namespace App\Http\Controllers;

use App\Models\KopAnggota;
use App\Models\KopPembiayaan;
use App\Models\KopPengajuan;
use App\Models\KopTabungan;
use App\Models\KopUser;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RegistrasiAkadController extends Controller
{
    function rembug(Request $request)
    {
        $token = $request->header('token');

        $param = array('token' => $token);

        $get = KopUser::where($param)->first();

        $show = KopPembiayaan::rembug($get->kode_cabang);

        $data = array();

        foreach ($show as $sh) {
            $kode_rembug = $sh->kode_rembug;
            $nama_rembug = $sh->nama_rembug;

            $data[] = array(
                'kode_rembug' => $kode_rembug,
                'nama_rembug' => $nama_rembug
            );
        }

        $res = array(
            'status' => TRUE,
            'data' => $data,
            'msg' => 'Berhasil!'
        );

        $response = response()->json($res, 200);

        return $response;
    }

    function pengajuan(Request $request)
    {
        $kode_rembug = $request->kode_rembug;

        $show = KopPembiayaan::pengajuan($kode_rembug);

        $data = array();

        foreach ($show as $sh) {
            $no_pengajuan = $sh->no_pengajuan;
            $no_anggota = $sh->no_anggota;
            $nama_cabang = $sh->nama_cabang;
            $nama_rembug = $sh->nama_rembug;
            $nama_anggota = $sh->nama_anggota;
            $jumlah_pengajuan = $sh->jumlah_pengajuan;
            $tanggal_pengajuan = $sh->tanggal_pengajuan;
            $rencana_droping = $sh->rencana_droping;
            $peruntukan = $sh->peruntukan;
            $keterangan_peruntukan = $sh->keterangan_peruntukan;
            $pengajuan_ke = $sh->pengajuan_ke;

            $data[] = array(
                'no_pengajuan' => $no_pengajuan,
                'no_anggota' => $no_anggota,
                'nama_anggota' => $nama_anggota,
                'nama_cabang' => $nama_cabang,
                'nama_rembug' => $nama_rembug,
                'jumlah_pengajuan' => str_replace('.00', '', $jumlah_pengajuan),
                'tanggal_pengajuan' => $tanggal_pengajuan,
                'rencana_droping' => $rencana_droping,
                'peruntukan' => $peruntukan,
                'keterangan_peruntukan' => $keterangan_peruntukan,
                'pembiayaan_ke' => $pengajuan_ke
            );
        }

        $res = array(
            'status' => TRUE,
            'data' => $data,
            'msg' => 'Berhasil!'
        );

        $response = response()->json($res, 200);

        return $response;
    }

    function fa(Request $request)
    {
        $token = $request->header('token');

        $param = array('token' => $token);

        $get = KopUser::where($param)->first();

        $show = KopPembiayaan::fa($get->kode_cabang);

        $data = array();

        foreach ($show as $sh) {
            $kode_petugas = $sh->kode_petugas;
            $nama_kas_petugas = $sh->nama_kas_petugas;

            $data[] = array(
                'kode_petugas' => $kode_petugas,
                'nama_kas_petugas' => $nama_kas_petugas
            );
        }

        $res = array(
            'status' => TRUE,
            'data' => $data,
            'msg' => 'Berhasil!'
        );

        $response = response()->json($res, 200);

        return $response;
    }

    function peruntukan()
    {
        $show = KopPembiayaan::peruntukan('peruntukan');

        $data = array();

        foreach ($show as $sh) {
            $kode_value = $sh->kode_value;
            $kode_display = $sh->kode_display;

            $data[] = array(
                'kode_value' => $kode_value,
                'kode_display' => $kode_display
            );
        }

        $res = array(
            'status' => TRUE,
            'data' => $data,
            'msg' => 'Berhasil!'
        );

        $response = response()->json($res, 200);

        return $response;
    }

    function product()
    {
        $show = KopPembiayaan::product();

        $data = array();

        foreach ($show as $sh) {
            $kode_produk = $sh->kode_produk;
            $kode_akad = $sh->kode_akad;
            $nama_produk = $sh->nama_produk;

            $data[] = array(
                'kode_produk' => $kode_produk,
                'kode_akad' => $kode_akad,
                'nama_produk' => $nama_produk
            );
        }

        $res = array(
            'status' => TRUE,
            'data' => $data,
            'msg' => 'Berhasil!'
        );

        $response = response()->json($res, 200);

        return $response;
    }

    function kreditur()
    {
        $show = KopPembiayaan::peruntukan('kreditur');

        $data = array();

        foreach ($show as $sh) {
            $kode_value = $sh->kode_value;
            $kode_display = $sh->kode_display;

            $data[] = array(
                'kode_value' => $kode_value,
                'kode_display' => $kode_display
            );
        }

        $res = array(
            'status' => TRUE,
            'data' => $data,
            'msg' => 'Berhasil!'
        );

        $response = response()->json($res, 200);

        return $response;
    }

    function create(Request $request)
    {
        $data = $request->all();

        $data['saldo_pokok'] = $request->pokok;
        $data['saldo_margin'] = $request->margin;
        $data['tanggal_registrasi'] = date('Y-m-d');

        if ($request->periode_jangka_waktu == 0) {
            $tanggal_mulai_angsur = date('Y-m-d', strtotime(str_replace('/', '-', $request->tanggal_akad) . ' + 1 DAY'));
            $tanggal_jtempo = date('Y-m-d', strtotime(str_replace('/', '-', $request->tanggal_akad) . ' + ' . $request->jangka_waktu . ' DAY'));
        } else if ($request->periode_jangka_waktu == 1) {
            $tanggal_mulai_angsur = date('Y-m-d', strtotime(str_replace('/', '-', $request->tanggal_akad) . ' + 1 WEEK'));
            $tanggal_jtempo = date('Y-m-d', strtotime(str_replace('/', '-', $request->tanggal_akad) . ' + ' . $request->jangka_waktu . ' WEEK'));
        } else if ($request->periode_jangka_waktu == 2) {
            $tanggal_mulai_angsur = date('Y-m-d', strtotime(str_replace('/', '-', $request->tanggal_akad) . ' + 1 MONTH'));
            $tanggal_jtempo = date('Y-m-d', strtotime(str_replace('/', '-', $request->tanggal_akad) . ' + ' . $request->jangka_waktu . ' MONTH'));
        } else {
            $tanggal_mulai_angsur = str_replace('/', '-', $request->tanggal_akad);
            $tanggal_jtempo = str_replace('/', '-', $request->tanggal_jtempo);
        }

        $default = '000';
        $format = $default . $request->pembiayaan_ke;
        $pengajuan_ke = substr($format, -3);

        $data['tanggal_mulai_angsur'] = $tanggal_mulai_angsur;
        $data['tanggal_jtempo'] = $tanggal_jtempo;
        $data['jtempo_angsuran_next'] = $tanggal_mulai_angsur;
        $data['no_rekening'] = $request->no_anggota . $request->kode_produk . $pengajuan_ke;
        $data['status_rekening'] = 1;
        $data['status_droping'] = 0;
        $data['verified_at'] = date('Y-m-d');
        $data['verified_by'] = $request->created_by;

        $validate = KopPembiayaan::validateAdd($data);

        $param = array('no_pengajuan' => $request->no_pengajuan);

        DB::beginTransaction();

        if ($validate['status'] === TRUE) {
            try {
                $create = KopPembiayaan::create($data);
                $find = KopPembiayaan::find($create->id);

                $getPengajuan = KopPengajuan::where($param)->first();
                $get = KopPengajuan::find($getPengajuan->id);
                $get->status_pengajuan = 1;

                $get->save();

                $res = array(
                    'status' => TRUE,
                    'data' => $find,
                    'msg' => 'Berhasil!'
                );

                DB::commit();
            } catch (Exception $e) {
                DB::rollBack();

                $res = array(
                    'status' => FALSE,
                    'data' => $data,
                    'msg' => $e->getMessage()
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

    public function read(Request $request)
    {
        $offset = 0;
        $page = 1;
        $perPage = '~';
        $sortDir = 'ASC';
        $sortBy = 'kop_pembiayaan.tanggal_registrasi';
        $search = NULL;
        $total = 0;
        $totalPage = 1;
        $jenis_pembiayaan = '~';
        $petugas = '~';
        $rembug = '~';
        $produk = '~';
        $status_rekening = '~';
        $status_droping = '~';
        $from = NULL;
        $to = NULL;

        $token = $request->header('token');
        $param = array('token' => $token);
        $get = KopUser::where($param)->first();
        $cabang = $get->kode_cabang;

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
            $search = strtoupper($request->search);
        }

        if ($request->status_rekening) {
            $status_rekening = $request->status_rekening;
        }

        if ($request->status_droping) {
            $status_droping = $request->status_droping;
        }

        if ($request->cabang) {
            $cabang = $request->cabang;
        }

        if ($request->jenis_pembiayaan) {
            $jenis_pembiayaan = $request->jenis_pembiayaan;
        }

        if ($request->petugas) {
            $petugas = $request->petugas;
        }

        if ($request->rembug) {
            $rembug = $request->rembug;
        }

        if ($request->produk) {
            $produk = $request->produk;
        }

        if ($request->from) {
            $from = str_replace('/', '-', $request->from);
            $from = date('Y-m-d', strtotime($from));
        }

        if ($request->to) {
            $to = str_replace('/', '-', $request->to);
            $to = date('Y-m-d', strtotime($to));
        }

        if ($page > 1) {
            $offset = ($page - 1) * $perPage;
        }

        $read = KopPembiayaan::select('kop_pembiayaan.*', 'kop_cabang.nama_cabang', 'kop_rembug.nama_rembug', 'kop_anggota.no_anggota', 'kop_anggota.nama_anggota', 'kop_anggota.tempat_lahir', 'kop_anggota.tgl_lahir', 'kop_anggota_uk.usia', 'kop_anggota.no_telp', 'kop_desa.nama_desa', 'kop_pengajuan.pengajuan_ke', DB::raw('(kop_pembiayaan.angsuran_pokok+kop_pembiayaan.angsuran_margin+kop_pembiayaan.angsuran_catab+kop_pembiayaan.angsuran_minggon) AS angsuran'), 'kop_prd_pembiayaan.nama_produk')
            ->join('kop_pengajuan', 'kop_pengajuan.no_pengajuan', 'kop_pembiayaan.no_pengajuan')
            ->join('kop_anggota', 'kop_anggota.no_anggota', 'kop_pengajuan.no_anggota')
            ->join('kop_anggota_uk', 'kop_anggota_uk.no_anggota', 'kop_anggota.no_anggota')
            ->join('kop_cabang', 'kop_cabang.kode_cabang', 'kop_anggota.kode_cabang')
            ->join('kop_prd_pembiayaan', 'kop_prd_pembiayaan.kode_produk', 'kop_pembiayaan.kode_produk')
            ->leftjoin('kop_rembug', 'kop_rembug.kode_rembug', 'kop_anggota.kode_rembug')
            ->leftjoin('kop_desa', 'kop_desa.kode_desa', 'kop_rembug.kode_desa')
            ->join('kop_list_kode AS klk', function ($join) {
                $join->on('klk.kode_value', 'kop_pembiayaan.peruntukan')->where('klk.nama_kode', '=', 'peruntukan');
            })
            ->leftjoin('kop_list_kode AS oio', function ($join) {
                $join->on('oio.kode_value', 'kop_pembiayaan.kode_kreditur')->where('oio.nama_kode', '=', 'kreditur');
            });

        if ($perPage != '~') {
            $read->skip($offset)->take($perPage);
        }

        if ($cabang != '00000') {
            $read->where('kop_cabang.kode_cabang', $cabang);
        }

        if ($jenis_pembiayaan && $jenis_pembiayaan != '~') {
            $read->where('kop_pengajuan.jenis_pembiayaan', $jenis_pembiayaan);
        }

        if ($petugas && $petugas != '~') {
            $read->where('kop_pembiayaan.kode_petugas', $petugas);
        }

        if ($rembug && $rembug != '~') {
            $read->where('kop_rembug.kode_rembug', $rembug);
        }

        if ($produk && $produk != '~') {
            $read->where('kop_pembiayaan.kode_produk', $produk);
        }

        if ($status_droping == 0) {
            $read->where('kop_pembiayaan.ttd_pencairan', null);
        }

        if ($status_rekening && $status_rekening != '~') {
            $read->whereIn('kop_pembiayaan.status_rekening', $status_rekening);
        }

        if ($status_droping && $status_droping != '~') {
            $read->whereIn('kop_pembiayaan.status_droping', $status_droping);
        }

        if ($search) {
            $read->where('kop_pengajuan.no_anggota', 'LIKE', '%' . $search . '%')
                ->orWhere('kop_pengajuan.no_pengajuan', 'LIKE', '%' . $search . '%');
        }

        if ($status_droping == 1) {
            if ($from && $to) {
                $read->whereBetween('kop_pembiayaan.tanggal_akad', [$from, $to]);
            }
        } else {
            if ($from && $to) {
                $read->whereBetween('kop_pembiayaan.tanggal_registrasi', [$from, $to]);
            }
        }

        $read = $read->orderBy($sortBy, $sortDir)->get();

        foreach ($read as $rd) {
            $useCount = 'used count diubah datanya disini';
            $rd->used_count = $useCount;
        }

        if ($search || $cabang || $jenis_pembiayaan || $petugas || $rembug || $produk || $status_rekening || ($from && $to)) {
            $total = KopPembiayaan::orderBy($sortBy, $sortDir)
                ->join('kop_pengajuan', 'kop_pengajuan.no_pengajuan', 'kop_pembiayaan.no_pengajuan')
                ->join('kop_anggota', 'kop_anggota.no_anggota', 'kop_pengajuan.no_anggota')
                ->leftjoin('kop_rembug', 'kop_rembug.kode_rembug', 'kop_anggota.kode_rembug');

            if ($cabang != '00000') {
                $total->where('kop_anggota.kode_cabang', $cabang);
            }

            if ($jenis_pembiayaan && $jenis_pembiayaan != '~') {
                $total->where('kop_pengajuan.jenis_pembiayaan', $jenis_pembiayaan);
            }

            if ($petugas && $petugas != '~') {
                $total->where('kop_pembiayaan.kode_petugas', $petugas);
            }

            if ($rembug && $rembug != '~') {
                $total->where('kop_rembug.kode_rembug', $rembug);
            }

            if ($produk && $produk != '~') {
                $total->where('kop_pembiayaan.kode_produk', $produk);
            }

            if ($status_rekening && $status_rekening != '~') {
                $total->whereIn('kop_pembiayaan.status_rekening', $status_rekening);
            }

            if ($status_droping && $status_droping != '~') {
                $total->whereIn('kop_pembiayaan.status_droping', $status_droping);
            }

            if ($search) {
                $total->where('kop_pengajuan.no_anggota', 'LIKE', '%' . $search . '%')
                    ->orWhere('kop_pengajuan.no_pengajuan', 'LIKE', '%' . $search . '%');
            }

            if ($status_droping == 1) {
                if ($from && $to) {
                    $read->whereBetween('kop_pembiayaan.tanggal_akad', [$from, $to]);
                }
            } else {
                if ($from && $to) {
                    $read->whereBetween('kop_pembiayaan.tanggal_registrasi', [$from, $to]);
                }
            }

            $total = $total->count();
        } else {
            $total = KopPembiayaan::all()->count();
        }

        if ($perPage != '~') {
            $totalPage = ceil($total / $perPage);
        }

        foreach ($read as $row) {
            $row->tgl_gabung = date('d-F-Y', strtotime($row->tgl_gabung));
        }

        $res = array(
            'status' => TRUE,
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

        $response = response()->json($res, 200);

        return $response;
    }

    public function detail(Request $request)
    {
        $id = $request->id;

        if ($id) {
            $get = KopPembiayaan::find($id);
            $get2 = KopPengajuan::select('kop_pengajuan.no_anggota', 'kop_anggota.nama_anggota', 'kop_pengajuan.pengajuan_ke', 'kop_pengajuan.tanggal_pengajuan', 'kop_pengajuan.keterangan_peruntukan', 'kop_rembug.kode_rembug', 'kop_rembug.nama_rembug')->join('kop_anggota', 'kop_anggota.no_anggota', '=', 'kop_pengajuan.no_anggota')->leftjoin('kop_rembug', 'kop_rembug.kode_rembug', '=', 'kop_anggota.kode_rembug')->where('kop_pengajuan.no_pengajuan', $get->no_pengajuan)->get();

            $data = array(
                'get' => $get,
                'get2' => $get2
            );

            if ($get) {
                $res = array(
                    'status' => TRUE,
                    'data' => $data,
                    'msg' => 'Berhasil!'
                );
            } else {
                $res = array(
                    'status' => FALSE,
                    'msg' => 'Maaf! Data tidak ditemukan'
                );
            }
        } else {
            $res = array(
                'status' => FALSE,
                'msg' => 'Maaf! Registrasi Akad tidak bisa ditampilkan'
            );
        }

        $response = response()->json($res, 200);

        return $response;
    }

    public function update(Request $request)
    {
        $get = KopPembiayaan::find($request->id);
        $validate = KopPembiayaan::validateUpdate($request->all());

        $get->kode_produk = $request->kode_produk;
        $get->kode_akad = $request->kode_akad;
        $get->kode_petugas = $request->kode_petugas;
        $get->pokok = $request->pokok;
        $get->margin = $request->margin;
        //$get->nisbah_bagihasil => $request->nisbah_bagihasil;
        $get->periode_jangka_waktu = $request->periode_jangka_waktu;
        $get->jangka_waktu = $request->jangka_waktu;
        $get->angsuran_pokok = $request->angsuran_pokok;
        $get->angsuran_margin = $request->angsuran_margin;
        //$get->angsuran_catab = $request->angsuran_catab;
        $get->angsuran_minggon = $request->angsuran_minggon;
        $get->biaya_administrasi = $request->biaya_administrasi;
        $get->biaya_asuransi_jiwa = $request->biaya_asuransi_jiwa;
        //$get->biaya_asuransi_jaminan = $request->biaya_asuransi_jaminan;
        //$get->biaya_notaris = $request->biaya_notaris;
        $get->tabungan_persen = $request->tabungan_persen;
        $get->dana_kebajikan = $request->dana_kebajikan;
        //$get->tanggal_registrasi = $request->tanggal_registrasi;
        $get->tanggal_akad = $request->tanggal_akad;

        if ($get->periode_jangka_waktu == 0) {
            $tanggal_mulai_angsur = date('Y-m-d', strtotime($get->tanggal_akad . ' + 1 DAY'));
            $tanggal_jtempo = date('Y-m-d', strtotime($get->tanggal_akad . ' + ' . $get->jangka_waktu . ' DAY'));
        } else if ($get->periode_jangka_waktu == 1) {
            $tanggal_mulai_angsur = date('Y-m-d', strtotime($get->tanggal_akad . ' + 1 WEEK'));
            $tanggal_jtempo = date('Y-m-d', strtotime($get->tanggal_akad . ' + ' . $get->jangka_waktu . ' WEEK'));
        } else if ($get->periode_jangka_waktu == 2) {
            $tanggal_mulai_angsur = date('Y-m-d', strtotime($get->tanggal_akad . ' + 1 MONTH'));
            $tanggal_jtempo = date('Y-m-d', strtotime($get->tanggal_akad . ' + ' . $get->jangka_waktu . ' MONTH'));
        } else {
            $tanggal_mulai_angsur = $get->tanggal_akad;
            $tanggal_jtempo = $get->tanggal_jtempo;
        }

        $get->tanggal_mulai_angsur = $tanggal_mulai_angsur;
        $get->tanggal_jtempo = $tanggal_jtempo;

        $get->saldo_pokok = $request->pokok;
        $get->saldo_margin = $request->margin;
        //$get->saldo_catab = $request->saldo_catab;
        $get->saldo_minggon = $request->saldo_minggon;
        //$get->jtempo_angsuran_last = $request->jtempo_angsuran_last;
        $get->jtempo_angsuran_next = $request->tanggal_mulai_angsur;
        $get->sumber_dana = $request->sumber_dana;
        //$get->dana_sendiri = $request->dana_sendiri;
        //$get->dana_kreditur = $request->dana_kreditur;
        $get->kode_kreditur = $request->kode_kreditur;
        //$get->ujroh_kreditur = $request->ujroh_kreditur;
        //$get->ujroh_kreditur_persen = $request->ujroh_kreditur_persen;
        //$get->ujroh_kreditur_nominal = $request->ujroh_kreditur_nominal;
        //$get->ujroh_kreditur_carabayar = $request->ujroh_kreditur_carabayar;
        //$get->angsuran_jadwal_khusus = $request->angsuran_jadwal_khusus;
        $get->peruntukan = $request->peruntukan;
        $get->norek_tabungan = $request->norek_tabungan;

        DB::beginTransaction();

        if ($validate['status'] === TRUE) {
            try {
                $get->save();

                $res = array(
                    'status' => TRUE,
                    'data' => NULL,
                    'msg' => 'Berhasil!'
                );

                DB::commit();
            } catch (Exception $e) {
                DB::rollBack();

                $res = array(
                    'status' => FALSE,
                    'data' => $request->all(),
                    'msg' => $e->getMessage()
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

        $response = response()->json($res, 200);

        return $response;
    }

    public function delete(Request $request)
    {
        $id = $request->id;

        if ($id) {
            $data = KopPembiayaan::find($id);

            DB::beginTransaction();

            try {
                $data->delete();

                $res = array(
                    'status' => TRUE,
                    'data' => NULL,
                    'msg' => 'Berhasil!'
                );

                DB::commit();
            } catch (Exception $e) {
                DB::rollBack();

                $res = array(
                    'status' => FALSE,
                    'data' => $request->all(),
                    'msg' => $e->getMessage()
                );
            }
        } else {
            $res = array(
                'status' => FALSE,
                'msg' => 'Maaf! Registrasi Akad tidak ditemukan'
            );
        }

        $response = response()->json($res, 200);

        return $response;
    }

    public function approve(Request $request)
    {
        $id = $request->id;
        $filePencairan = $request->doc_pencairan;
        $fileTtdPencairan = $request->ttd_pencairan;

        $data = KopPembiayaan::find($id);
        $getPengajuan = KopPengajuan::where('no_pengajuan', $data->no_pengajuan)->first();
        $getAnggota = KopAnggota::where('no_anggota', $getPengajuan->no_anggota)->first();
        $sequence = KopTabungan::get_seq_rekening($getAnggota->no_anggota, '099');

        if ($sequence['jumlah'] == 0) {
            $no_rekening = $getAnggota->no_anggota . '09901';
            $createSaving = array(
                'no_anggota' => $getAnggota->no_anggota,
                'kode_produk' => '099',
                'setoran' => 0,
                'periode_setoran' => 0,
                'jangka_waktu' => 0,
                'no_rekening' => $no_rekening,
                'flag_taber' => 0,
                'tanggal_buka' => date('Y-m-d'),
                'created_by' => 'SYSTEM'
            );
        }

        if (empty($filePencairan)) {
            $doc_pencairan = NULL;
        } else {
            $name_pendukung = 'dokumen_pencairan_' . $data->no_rekening . '.png';
            $path_pendukung = 'document/' . $name_pendukung;

            Storage::disk('public')->put($path_pendukung, file_get_contents($filePencairan));

            $doc_pencairan = $name_pendukung;
        }

        if (empty($fileTtdPencairan)) {
            $ttd_pencairan = NULL;
        } else {
            $name_ttd_pencairan = 'ttd_pencairan_' . $data->no_rekening . '.png';
            $path_ttd_pencairan = 'document/' . $name_ttd_pencairan;

            Storage::disk('public')->put($path_ttd_pencairan, file_get_contents($fileTtdPencairan));

            $ttd_pencairan = $name_ttd_pencairan;
        }

        if ($id) {
            $data->doc_pencairan = $doc_pencairan;
            $data->ttd_pencairan = $ttd_pencairan;

            DB::beginTransaction();

            try {
                $data->save();
                if ($sequence['jumlah'] == 0) {
                    KopTabungan::create($createSaving);
                }

                KopPembiayaan::buat_karwas($data->no_rekening);

                $res = array(
                    'status' => TRUE,
                    'data' => NULL,
                    'msg' => 'Berhasil!'
                );

                DB::commit();
            } catch (Exception $e) {
                DB::rollBack();

                $res = array(
                    'status' => FALSE,
                    'data' => $request->all(),
                    'msg' => $e->getMessage()
                );
            }
        } else {
            $res = array(
                'status' => FALSE,
                'msg' => 'Maaf! Registrasi Akad tidak ditemukan'
            );
        }

        $response = response()->json($res, 200);

        return $response;
    }

    public function reject(Request $request)
    {
        $id = $request->id;

        if ($id) {
            $data = KopPembiayaan::find($id);

            $param = array('no_pengajuan' => $data->no_pengajuan);

            $update = KopPengajuan::where($param)->first();
            $update->status_pengajuan = 2;

            DB::beginTransaction();

            try {
                $update->save();
                $data->delete();

                $res = array(
                    'status' => TRUE,
                    'data' => NULL,
                    'msg' => 'Berhasil!'
                );

                DB::commit();
            } catch (Exception $e) {
                DB::rollBack();

                $res = array(
                    'status' => FALSE,
                    'data' => $request->all(),
                    'msg' => $e->getMessage()
                );
            }
        } else {
            $res = array(
                'status' => FALSE,
                'msg' => 'Maaf! Registrasi Akad tidak ditemukan'
            );
        }

        $response = response()->json($res, 200);

        return $response;
    }
}
