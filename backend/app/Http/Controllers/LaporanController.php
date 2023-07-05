<?php

namespace App\Http\Controllers;

use App\Exports\BukuBesarExport;
use App\Exports\JurnalTransaksiExport;
use App\Exports\KartuAngsuranExport;
use App\Exports\KasPetugasExport;
use App\Exports\ListAnggotaMasukExport;
use App\Exports\ListPengajuanExport;
use App\Exports\ListRegisAkadExport;
use App\Exports\ListPencairanExport;
use App\Exports\ListSaldoAnggotaExport;
use App\Exports\ListSaldoOutstandingExport;
use App\Exports\TransaksiMajelisExport;
use App\Models\KopAnggota;
use App\Models\KopCabang;
use App\Models\KopPembiayaan;
use App\Models\KopRembug;
use App\Models\KopTabungan;
use App\Models\KopTrxGl;
use App\Models\KopTrxGlDetail;
use App\Models\KopTrxRembug;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    function list_excel_anggota_masuk(Request $request)
    {
        $list = new ListAnggotaMasukExport($request->kode_cabang, $request->kode_rembug, $request->from_date, $request->thru_date, 'excel');

        if ($request->kode_cabang <> '~') {
            $branch = KopCabang::where('kode_cabang', $request->kode_cabang)->first();
            $cabang = str_replace(' ', '_', $branch->nama_cabang);
        } else {
            $cabang = 'SEMUA_CABANG';
        }

        if ($request->kode_rembug <> '~') {
            $cm = KopRembug::where('kode_rembug', $request->kode_rembug)->first();
            $rembug = str_replace(' ', '_', $cm->nama_rembug);
        } else {
            $rembug = 'SEMUA_REMBUG';
        }

        return $list->download('LAPORAN_LIST_ANGGOTA_MASUK_' . $cabang . '_' . $rembug . '_' . $request->from_date . '_' . $request->thru_date . '.xlsx');
    }

    function list_csv_anggota_masuk(Request $request)
    {
        $list = new ListAnggotaMasukExport($request->kode_cabang, $request->kode_rembug, $request->from_date, $request->thru_date, 'csv');

        if ($request->kode_cabang <> '~') {
            $branch = KopCabang::where('kode_cabang', $request->kode_cabang)->first();
            $cabang = str_replace(' ', '_', $branch->nama_cabang);
        } else {
            $cabang = 'SEMUA_CABANG';
        }

        if ($request->kode_rembug <> '~') {
            $cm = KopRembug::where('kode_rembug', $request->kode_rembug)->first();
            $rembug = str_replace(' ', '_', $cm->nama_rembug);
        } else {
            $rembug = 'SEMUA_REMBUG';
        }

        return $list->download('LAPORAN_LIST_ANGGOTA_MASUK_' . $cabang . '_' . $rembug . '_' . $request->from_date . '_' . $request->thru_date . '.csv');
    }

    function list_excel_pengajuan(Request $request)
    {
        $list = new ListPengajuanExport($request->kode_cabang, $request->jenis_pembiayaan, $request->kode_petugas, $request->kode_rembug, $request->from_date, $request->thru_date, 'excel');

        if ($request->kode_cabang <> '~') {
            $branch = KopCabang::where('kode_cabang', $request->kode_cabang)->first();
            $cabang = str_replace(' ', '_', $branch->nama_cabang);
        } else {
            $cabang = 'SEMUA_CABANG';
        }

        if ($request->kode_rembug <> '~') {
            $cm = KopRembug::where('kode_rembug', $request->kode_rembug)->first();
            $rembug = str_replace(' ', '_', $cm->nama_rembug);
        } else {
            $rembug = 'SEMUA_REMBUG';
        }

        return $list->download('LAPORAN_LIST_PENGAJUAN_' . $cabang . '_' . $rembug . '_' . $request->from_date . '_' . $request->thru_date . '.xlsx');
    }

    function list_csv_pengajuan(Request $request)
    {
        $list = new ListPengajuanExport($request->kode_cabang, $request->jenis_pembiayaan, $request->kode_petugas, $request->kode_rembug, $request->from_date, $request->thru_date, 'csv');

        if ($request->kode_cabang <> '~') {
            $branch = KopCabang::where('kode_cabang', $request->kode_cabang)->first();
            $cabang = str_replace(' ', '_', $branch->nama_cabang);
        } else {
            $cabang = 'SEMUA_CABANG';
        }

        if ($request->kode_rembug <> '~') {
            $cm = KopRembug::where('kode_rembug', $request->kode_rembug)->first();
            $rembug = str_replace(' ', '_', $cm->nama_rembug);
        } else {
            $rembug = 'SEMUA_REMBUG';
        }

        return $list->download('LAPORAN_LIST_PENGAJUAN_' . $cabang . '_' . $rembug . '_' . $request->from_date . '_' . $request->thru_date . '.csv');
    }

    function list_excel_regis_akad(Request $request)
    {
        $list = new ListRegisAkadExport($request->kode_cabang, $request->jenis_pembiayaan, $request->kode_petugas, $request->kode_rembug, $request->produk, $request->from_date, $request->thru_date, 'excel');

        if ($request->kode_cabang <> '~') {
            $branch = KopCabang::where('kode_cabang', $request->kode_cabang)->first();
            $cabang = str_replace(' ', '_', $branch->nama_cabang);
        } else {
            $cabang = 'SEMUA_CABANG';
        }

        if ($request->kode_rembug <> '~') {
            $cm = KopRembug::where('kode_rembug', $request->kode_rembug)->first();
            $rembug = str_replace(' ', '_', $cm->nama_rembug);
        } else {
            $rembug = 'SEMUA_REMBUG';
        }

        return $list->download('LAPORAN_LIST_REGISTRASI_AKAD_' . $cabang . '_' . $rembug . '_' . $request->from_date . '_' . $request->thru_date . '.xlsx');
    }

    function list_csv_regis_akad(Request $request)
    {
        $list = new ListRegisAkadExport($request->kode_cabang, $request->jenis_pembiayaan, $request->kode_petugas, $request->kode_rembug, $request->produk, $request->from_date, $request->thru_date, 'csv');

        if ($request->kode_cabang <> '~') {
            $branch = KopCabang::where('kode_cabang', $request->kode_cabang)->first();
            $cabang = str_replace(' ', '_', $branch->nama_cabang);
        } else {
            $cabang = 'SEMUA_CABANG';
        }

        if ($request->kode_rembug <> '~') {
            $cm = KopRembug::where('kode_rembug', $request->kode_rembug)->first();
            $rembug = str_replace(' ', '_', $cm->nama_rembug);
        } else {
            $rembug = 'SEMUA_REMBUG';
        }

        return $list->download('LAPORAN_LIST_REGISTRASI_AKAD_' . $cabang . '_' . $rembug . '_' . $request->from_date . '_' . $request->thru_date . '.csv');
    }

    function list_excel_pencairan(Request $request)
    {
        $list = new ListPencairanExport($request->kode_cabang, $request->jenis_pembiayaan, $request->kode_petugas, $request->kode_rembug, $request->produk, $request->from_date, $request->thru_date, 'excel');

        if ($request->kode_cabang <> '~') {
            $branch = KopCabang::where('kode_cabang', $request->kode_cabang)->first();
            $cabang = str_replace(' ', '_', $branch->nama_cabang);
        } else {
            $cabang = 'SEMUA_CABANG';
        }

        if ($request->kode_rembug <> '~') {
            $cm = KopRembug::where('kode_rembug', $request->kode_rembug)->first();
            $rembug = str_replace(' ', '_', $cm->nama_rembug);
        } else {
            $rembug = 'SEMUA_REMBUG';
        }

        return $list->download('LAPORAN_LIST_PENCAIRAN_' . $cabang . '_' . $rembug . '_' . $request->from_date . '_' . $request->thru_date . '.xlsx');
    }

    function list_csv_pencairan(Request $request)
    {
        $list = new ListPencairanExport($request->kode_cabang, $request->jenis_pembiayaan, $request->kode_petugas, $request->kode_rembug, $request->produk, $request->from_date, $request->thru_date, 'csv');

        if ($request->kode_cabang <> '~') {
            $branch = KopCabang::where('kode_cabang', $request->kode_cabang)->first();
            $cabang = str_replace(' ', '_', $branch->nama_cabang);
        } else {
            $cabang = 'SEMUA_CABANG';
        }

        if ($request->kode_rembug <> '~') {
            $cm = KopRembug::where('kode_rembug', $request->kode_rembug)->first();
            $rembug = str_replace(' ', '_', $cm->nama_rembug);
        } else {
            $rembug = 'SEMUA_REMBUG';
        }

        return $list->download('LAPORAN_LIST_PENCAIRAN_' . $cabang . '_' . $rembug . '_' . $request->from_date . '_' . $request->thru_date . '.csv');
    }

    function list_excel_saldo_anggota(Request $request)
    {
        $list = new ListSaldoAnggotaExport($request->kode_cabang, $request->kode_rembug, $request->from_date, $request->thru_date, 'excel');

        if ($request->kode_cabang <> '~') {
            $branch = KopCabang::where('kode_cabang', $request->kode_cabang)->first();
            $cabang = str_replace(' ', '_', $branch->nama_cabang);
        } else {
            $cabang = 'SEMUA_CABANG';
        }

        if ($request->kode_rembug <> '~') {
            $cm = KopRembug::where('kode_rembug', $request->kode_rembug)->first();
            $rembug = str_replace(' ', '_', $cm->nama_rembug);
        } else {
            $rembug = 'SEMUA_REMBUG';
        }

        return $list->download('LAPORAN_SALDO_ANGGOTA_' . $cabang . '_' . $rembug . '.xlsx');
    }

    function list_csv_saldo_anggota(Request $request)
    {
        $list = new ListSaldoAnggotaExport($request->kode_cabang, $request->kode_rembug, $request->from_date, $request->thru_date, 'csv');

        if ($request->kode_cabang <> '~') {
            $branch = KopCabang::where('kode_cabang', $request->kode_cabang)->first();
            $cabang = str_replace(' ', '_', $branch->nama_cabang);
        } else {
            $cabang = 'SEMUA_CABANG';
        }

        if ($request->kode_rembug <> '~') {
            $cm = KopRembug::where('kode_rembug', $request->kode_rembug)->first();
            $rembug = str_replace(' ', '_', $cm->nama_rembug);
        } else {
            $rembug = 'SEMUA_REMBUG';
        }

        return $list->download('LAPORAN_SALDO_ANGGOTA_' . $cabang . '_' . $rembug . '.csv');
    }

    function list_excel_saldo_outstanding(Request $request)
    {
        $list = new ListSaldoOutstandingExport($request->kode_cabang, $request->kode_rembug, 'excel');

        if ($request->kode_cabang <> '~') {
            $branch = KopCabang::where('kode_cabang', $request->kode_cabang)->first();
            $cabang = str_replace(' ', '_', $branch->nama_cabang);
        } else {
            $cabang = 'SEMUA_CABANG';
        }

        if ($request->kode_rembug <> '~') {
            $cm = KopRembug::where('kode_rembug', $request->kode_rembug)->first();
            $rembug = str_replace(' ', '_', $cm->nama_rembug);
        } else {
            $rembug = 'SEMUA_REMBUG';
        }

        return $list->download('LAPORAN_SALDO_OUTSTANDING_' . $cabang . '_' . $rembug . '.xlsx');
    }

    function list_csv_saldo_outstanding(Request $request)
    {
        $list = new ListSaldoOutstandingExport($request->kode_cabang, $request->kode_rembug, 'csv');

        if ($request->kode_cabang <> '~') {
            $branch = KopCabang::where('kode_cabang', $request->kode_cabang)->first();
            $cabang = str_replace(' ', '_', $branch->nama_cabang);
        } else {
            $cabang = 'SEMUA_CABANG';
        }

        if ($request->kode_rembug <> '~') {
            $cm = KopRembug::where('kode_rembug', $request->kode_rembug)->first();
            $rembug = str_replace(' ', '_', $cm->nama_rembug);
        } else {
            $rembug = 'SEMUA_REMBUG';
        }

        return $list->download('LAPORAN_SALDO_ANGGOTA_' . $cabang . '_' . $rembug . '.csv');
    }

    function list_excel_kartu_angsuran(Request $request)
    {
        $list = new KartuAngsuranExport($request->no_rekening, 'excel');

        return $list->download('LAPORAN_KARTU_ANGSURAN_' . $request->no_rekening . '.xlsx');
    }

    function list_csv_kartu_angsuran(Request $request)
    {
        $list = new KartuAngsuranExport($request->no_rekening, 'csv');

        return $list->download('LAPORAN_KARTU_ANGSURAN_' . $request->no_rekening . '.csv');
    }

    function list_excel_kas_petugas(Request $request)
    {
        $list = new KasPetugasExport($request->kode_kas_petugas, $request->from_date, $request->thru_date, 'excel');

        return $list->download('LAPORAN_KAS_PETUGAS_' . $request->kode_kas_petugas . '_' . $request->from_date . '_' . $request->thru_date . '.xlsx');
    }

    function list_csv_kas_petugas(Request $request)
    {
        $list = new KasPetugasExport($request->kode_kas_petugas, $request->from_date, $request->thru_date, 'csv');

        return $list->download('LAPORAN_KAS_PETUGAS_' . $request->kode_kas_petugas . '_' . $request->from_date . '_' . $request->thru_date . '.csv');
    }

    function list_pdf_jurnal_transaksi(Request $request)
    {
        $kode_cabang = $request->kode_cabang;

        if ($request->from_date) {
            $from_date = date('Y-m-d', strtotime(str_replace('/', '-', $request->from_date)));
        } else {
            $from_date = date('Y-m-d');
        }

        if ($request->thru_date) {
            $thru_date = date('Y-m-d', strtotime(str_replace('/', '-', $request->thru_date)));
        } else {
            $thru_date = date('Y-m-d');
        }

        $show = KopTrxGl::get_ledger($kode_cabang, $from_date, $thru_date);

        if ($kode_cabang <> '~') {
            $branch = KopCabang::where('kode_cabang', $kode_cabang)->first();

            if ($branch <> '00000') {
                $cabang = $branch->nama_cabang;
            } else {
                $cabang = 'SEMUA CABANG';
            }
        } else {
            $cabang = 'SEMUA CABANG';
        }

        foreach ($show as $sh) {
            $detail = KopTrxGlDetail::get_ledger_detail($sh->id_trx_gl);

            $sh->detail = $detail;
        }

        $res = array(
            'status' => true,
            'nama_cabang' => $cabang,
            'from_date' => $from_date,
            'thru_date' => $thru_date,
            'data' => $show
        );

        $response = response()->json($res, 200);

        return $response;
    }

    function list_excel_jurnal_transaksi(Request $request)
    {
        $list = new JurnalTransaksiExport($request->kode_cabang, $request->from_date, $request->thru_date, 'excel');

        return $list->download('LAPORAN_JURNAL_TRANSAKSI_' . $request->kode_cabang . '_' . $request->from_date . '_' . $request->thru_date . '.xlsx');
    }

    function list_pdf_profil_anggota(Request $request)
    {
        $getAnggota = KopAnggota::get_profile($request->no_anggota);
        $data = array(
            'nama_anggota' => $getAnggota['nama_anggota'],
            'no_ktp' => $getAnggota['no_ktp'],
            'alamat' => $getAnggota['alamat'],
            'nama_rembug' => $getAnggota['nama_rembug']
        );

        $getTabungan = KopTabungan::get_profile($request->no_anggota);
        if (count($getTabungan) > 0) {
            foreach ($getTabungan as $tabungan) {
                $data['tabungan'][] = array(
                    'no_rekening' => $tabungan['no_rekening'],
                    'nama_produk' => $tabungan['nama_produk'],
                    'tanggal_buka' => $tabungan['tanggal_buka'],
                    'jangka_waktu' => $tabungan['jangka_waktu'],
                    'jatuh_tempo' => $tabungan['jatuh_tempo'],
                    'saldo' => $tabungan['saldo'],
                    'status_rekening' => $tabungan['status_rekening']
                );
            }
        } else {
            $data['tabungan'][] = array();
        }

        $getPembiayaan = KopPembiayaan::get_financing_member($request->no_anggota);
        if (count($getPembiayaan) > 0) {
            foreach ($getPembiayaan as $pembiayaan) {
                if ($pembiayaan['status_rekening'] == 0) {
                    $status_rekening = 'Registrasi';
                } else if ($pembiayaan['status_rekening'] == 1) {
                    $status_rekening = 'Aktif';
                } else if ($pembiayaan['status_rekening'] == 1) {
                    $status_rekening = 'Lunas';
                } else {
                    $status_rekening = 'Verifikasi Anggota Keluar';
                }

                $data['pembiayaan'][] = array(
                    'no_rekening' => $pembiayaan['no_rekening'],
                    'nama_produk' => $pembiayaan['nama_produk'],
                    'pokok' => $pembiayaan['pokok'],
                    'margin' => $pembiayaan['margin'],
                    'tanggal_akad' => $pembiayaan['tanggal_akad'],
                    'jangka_waktu' => $pembiayaan['jangka_waktu'],
                    'saldo_pokok' => $pembiayaan['saldo_pokok'],
                    'saldo_margin' => $pembiayaan['saldo_margin'],
                    'saldo_catab' => $pembiayaan['saldo_catab'],
                    'status_rekening' => $status_rekening
                );
            }
        } else {
            $data['pembiayaan'][] = array();
        }

        $res = array(
            'status' => true,
            'data' => $data
        );

        $response = response()->json($res, 200);

        return $response;
    }

    function list_pdf_detail_profil_anggota(Request $request)
    {
        $getCabang = KopCabang::where(array('kode_cabang' => $request->kode_cabang))->first();
        $getRembug = KopRembug::where(array('kode_rembug' => $request->kode_rembug))->first();
        $getAnggota = KopAnggota::get_profile($request->no_anggota);

        $data = array(
            'nama_cabang' => $getCabang['nama_cabang'],
            'nama_rembug' => $getRembug['nama_rembug']
        );

        if ($getAnggota['jenis_kelamin'] == 'P') {
            $jenis_kelamin = 'PRIA';
        } else {
            $jenis_kelamin = 'WANITA';
        }

        if ($getAnggota['pendidikan'] == 0) {
            $pendidikan = 'TIDAK DIKETAHUI';
        } else if ($getAnggota['pendidikan'] == 1) {
            $pendidikan = 'SD / MI';
        } else if ($getAnggota['pendidikan'] == 2) {
            $pendidikan = 'SMP / MTs';
        } else if ($getAnggota['pendidikan'] == 3) {
            $pendidikan = 'SMK / SMA / MA';
        } else if ($getAnggota['pendidikan'] == 4) {
            $pendidikan = 'D1';
        } else if ($getAnggota['pendidikan'] == 5) {
            $pendidikan = 'D2';
        } else if ($getAnggota['pendidikan'] == 6) {
            $pendidikan = 'D3';
        } else if ($getAnggota['pendidikan'] == 7) {
            $pendidikan = 'S1';
        } else if ($getAnggota['pendidikan'] == 8) {
            $pendidikan = 'S2';
        } else {
            $pendidikan = 'S3';
        }

        if ($getAnggota['status_perkawinan'] == 0) {
            $status_perkawinan = 'TIDAK DIKETAHUI';
        } else if ($getAnggota['status_perkawinan'] == 1) {
            $status_perkawinan = 'KAWIN';
        } else {
            $status_perkawinan = 'BELUM';
        }

        if ($getAnggota['pekerjaan'] == 0) {
            $pekerjaan = 'TIDAK DIKETAHUI';
        } else if ($getAnggota['pekerjaan'] == 1) {
            $pekerjaan = 'IBU RUMAH TANGGA';
        } else if ($getAnggota['pekerjaan'] == 2) {
            $pekerjaan = 'BURUH';
        } else if ($getAnggota['pekerjaan'] == 3) {
            $pekerjaan = 'PETANI';
        } else if ($getAnggota['pekerjaan'] == 4) {
            $pekerjaan = 'PEDAGANG';
        } else if ($getAnggota['pekerjaan'] == 5) {
            $pekerjaan = 'WIRASWASTA';
        } else if ($getAnggota['pekerjaan'] == 6) {
            $pekerjaan = 'KARYAWAN SWASTA';
        } else {
            $pekerjaan = 'PNS';
        }

        $data['anggota'] = array(
            'no_anggota' => $getAnggota['no_anggota'],
            'nama_anggota' => $getAnggota['nama_anggota'],
            'jenis_kelamin' => $jenis_kelamin,
            'ibu_kandung' => $getAnggota['ibu_kandung'],
            'tempat_lahir' => $getAnggota['tempat_lahir'],
            'tgl_lahir' => $getAnggota['tgl_lahir'],
            'alamat' => $getAnggota['alamat'],
            'desa' => $getAnggota['desa'],
            'kecamatan' => $getAnggota['kecamatan'],
            'kabupaten' => $getAnggota['kabupaten'],
            'kodepos' => $getAnggota['kodepos'],
            'no_ktp' => $getAnggota['no_ktp'],
            'no_npwp' => $getAnggota['no_npwp'],
            'no_telp' => $getAnggota['no_telp'],
            'pendidikan' => $pendidikan,
            'status_perkawinan' => $status_perkawinan,
            'nama_pasangan' => $getAnggota['nama_pasangan'],
            'pekerjaan' => $pekerjaan,
            'ket_pekerjaan' => $getAnggota['ket_pekerjaan'],
            'pendapatan_perbulan' => $getAnggota['pendapatan_perbulan'],
            'simpok' => $getAnggota['simpok'],
            'simwa' => $getAnggota['simwa'],
            'simsuk' => $getAnggota['simsuk'],
            'tgl_gabung' => $getAnggota['tgl_gabung']
        );

        if ($getAnggota['p_pendidikan'] == 0) {
            $p_pendidikan = 'TIDAK DIKETAHUI';
        } else if ($getAnggota['p_pendidikan'] == 1) {
            $p_pendidikan = 'SD / MI';
        } else if ($getAnggota['p_pendidikan'] == 2) {
            $p_pendidikan = 'SMP / MTs';
        } else if ($getAnggota['p_pendidikan'] == 3) {
            $p_pendidikan = 'SMK / SMA / MA';
        } else if ($getAnggota['p_pendidikan'] == 4) {
            $p_pendidikan = 'D1';
        } else if ($getAnggota['p_pendidikan'] == 5) {
            $p_pendidikan = 'D2';
        } else if ($getAnggota['p_pendidikan'] == 6) {
            $p_pendidikan = 'D3';
        } else if ($getAnggota['p_pendidikan'] == 7) {
            $p_pendidikan = 'S1';
        } else if ($getAnggota['p_pendidikan'] == 8) {
            $p_pendidikan = 'S2';
        } else {
            $p_pendidikan = 'S3';
        }

        if ($getAnggota['p_pekerjaan'] == 0) {
            $p_pekerjaan = 'TIDAK DIKETAHUI';
        } else if ($getAnggota['p_pekerjaan'] == 1) {
            $p_pekerjaan = 'IBU RUMAH TANGGA';
        } else if ($getAnggota['p_pekerjaan'] == 2) {
            $p_pekerjaan = 'BURUH';
        } else if ($getAnggota['p_pekerjaan'] == 3) {
            $p_pekerjaan = 'PETANI';
        } else if ($getAnggota['p_pekerjaan'] == 4) {
            $p_pekerjaan = 'PEDAGANG';
        } else if ($getAnggota['p_pekerjaan'] == 5) {
            $p_pekerjaan = 'WIRASWASTA';
        } else if ($getAnggota['p_pekerjaan'] == 6) {
            $p_pekerjaan = 'KARYAWAN SWASTA';
        } else {
            $p_pekerjaan = 'PNS';
        }

        if ($getAnggota['rumah_status'] == 0) {
            $rumah_status = 'TIDAK DIKETAHUI';
        } else if ($getAnggota['rumah_status'] == 1) {
            $rumah_status = 'RUMAH SENDIRI';
        } else if ($getAnggota['rumah_status'] == 2) {
            $rumah_status = 'SEWA';
        } else {
            $rumah_status = 'NUMPANG';
        }

        if ($getAnggota['rumah_ukuran'] == 0) {
            $rumah_ukuran = 'TIDAK DIKETAHUI';
        } else if ($getAnggota['rumah_ukuran'] == 1) {
            $rumah_ukuran = 'KECIL';
        } else if ($getAnggota['rumah_ukuran'] == 2) {
            $rumah_ukuran = 'BESAR';
        } else {
            $rumah_ukuran = 'SEDANG';
        }

        if ($getAnggota['rumah_atap'] == 0) {
            $rumah_atap = 'TIDAK DIKETAHUI';
        } else if ($getAnggota['rumah_atap'] == 1) {
            $rumah_atap = 'GENTENG';
        } else if ($getAnggota['rumah_atap'] == 2) {
            $rumah_atap = 'ASBES';
        } else {
            $rumah_atap = 'RUMBIA';
        }

        if ($getAnggota['rumah_dinding'] == 0) {
            $rumah_dinding = 'TIDAK DIKETAHUI';
        } else if ($getAnggota['rumah_dinding'] == 1) {
            $rumah_dinding = 'TEMBOK';
        } else if ($getAnggota['rumah_dinding'] == 2) {
            $rumah_dinding = 'SEMI TEMBOK';
        } else if ($getAnggota['rumah_dinding'] == 3) {
            $rumah_dinding = 'PAPAN';
        } else {
            $rumah_dinding = 'BAMBU';
        }

        if ($getAnggota['rumah_lantai'] == 0) {
            $rumah_lantai = 'TIDAK DIKETAHUI';
        } else if ($getAnggota['rumah_lantai'] == 1) {
            $rumah_lantai = 'TANAH';
        } else if ($getAnggota['rumah_lantai'] == 2) {
            $rumah_lantai = 'SEMEN';
        } else {
            $rumah_lantai = 'KERAMIK';
        }

        if ($getAnggota['rumah_jamban'] == 0) {
            $rumah_jamban = 'TIDAK DIKETAHUI';
        } else if ($getAnggota['rumah_jamban'] == 1) {
            $rumah_jamban = 'SUNGAI';
        } else if ($getAnggota['rumah_jamban'] == 2) {
            $rumah_jamban = 'JAMBAN TERBUKA';
        } else {
            $rumah_jamban = 'WC';
        }

        if ($getAnggota['rumah_air'] == 0) {
            $rumah_air = 'TIDAK DIKETAHUI';
        } else if ($getAnggota['rumah_air'] == 1) {
            $rumah_air = 'SUMUR SENDIRI';
        } else if ($getAnggota['rumah_air'] == 2) {
            $rumah_air = 'SUMUR BERSAMA';
        } else if ($getAnggota['rumah_air'] == 3) {
            $rumah_air = 'SUNGAI';
        } else {
            $rumah_air = 'PDAM / PAMSIMAS';
        }

        if ($getAnggota['ush_rumahtangga'] == 0) {
            $ush_rumahtangga = 'TIDAK DIKETAHUI';
        } else if ($getAnggota['ush_rumahtangga'] == 1) {
            $ush_rumahtangga = 'PERDAGANGAN';
        } else if ($getAnggota['ush_rumahtangga'] == 2) {
            $ush_rumahtangga = 'PERTANIAN';
        } else if ($getAnggota['ush_rumahtangga'] == 3) {
            $ush_rumahtangga = 'INDUSTRI PENGOLAHAN';
        } else if ($getAnggota['ush_rumahtangga'] == 4) {
            $ush_rumahtangga = 'JASA';
        } else if ($getAnggota['ush_rumahtangga'] == 5) {
            $ush_rumahtangga = 'KARYAWAN';
        } else if ($getAnggota['ush_rumahtangga'] == 6) {
            $ush_rumahtangga = 'PERIKANAN';
        } else {
            $ush_rumahtangga = 'LAINNYA';
        }

        $data['uk'] = array(
            'p_nama' => $getAnggota['p_nama'],
            'p_tmplahir' => $getAnggota['p_tmplahir'],
            'p_tglahir' => $getAnggota['p_tglahir'],
            'usia' => $getAnggota['usia'],
            'p_noktp' => $getAnggota['p_noktp'],
            'p_nohp' => $getAnggota['p_nohp'],
            'p_pendidikan' => $p_pendidikan,
            'p_pekerjaan' => $p_pekerjaan,
            'p_ketpekerjaan' => $getAnggota['p_ketpekerjaan'],
            'p_pendapatan' => $getAnggota['p_pendapatan'],
            'jml_anak' => $getAnggota['jml_anak'],
            'jml_tanggungan' => $getAnggota['jml_tanggungan'],
            'rumah_status' => $rumah_status,
            'rumah_ukuran' => $rumah_ukuran,
            'rumah_atap' => $rumah_atap,
            'rumah_dinding' => $rumah_dinding,
            'rumah_lantai' => $rumah_lantai,
            'rumah_jamban' => $rumah_jamban,
            'rumah_air' => $rumah_air,
            'lahan_sawah' => $getAnggota['lahan_sawah'],
            'lahan_kebun' => $getAnggota['lahan_kebun'],
            'lahan_pekarangan' => $getAnggota['lahan_pekarangan'],
            'ternak_sapi' => $getAnggota['ternak_sapi'],
            'ternak_domba' => $getAnggota['ternak_domba'],
            'ternak_unggas' => $getAnggota['ternak_unggas'],
            'elc_kulkas' => ($getAnggota['elc_kulkas'] == 0 ? 'TIDAK MEMILIKI' : 'MEMILIKI'),
            'elc_tv' => ($getAnggota['elc_tv'] == 0 ? 'TIDAK MEMILIKI' : 'MEMILIKI'),
            'elc_hp' => ($getAnggota['elc_hp'] == 0 ? 'TIDAK MEMILIKI' : 'MEMILIKI'),
            'kend_sepeda' => $getAnggota['kend_sepeda'],
            'kend_motor' => $getAnggota['kend_motor'],
            'ush_rumahtangga' => $ush_rumahtangga,
            'ush_komoditi' => $getAnggota['ush_komoditi'],
            'ush_lokasi' => $getAnggota['ush_lokasi'],
            'ush_omset' => $getAnggota['ush_omset'],
            'by_beras' => $getAnggota['by_beras'],
            'by_dapur' => $getAnggota['by_dapur'],
            'by_listrik' => $getAnggota['by_listrik'],
            'by_telpon' => $getAnggota['by_telpon'],
            'by_sekolah' => $getAnggota['by_sekolah'],
            'by_lain' => $getAnggota['by_lain']
        );

        $res = array(
            'status' => true,
            'data' => $data
        );

        $response = response()->json($res, 200);

        return $response;
    }

    function list_pdf_detail_transaksi_majelis(Request $request)
    {
        $kode_cabang = $request->branch_code;
        $kode_petugas = $request->fa_code;
        $kode_rembug = $request->cm_code;

        if ($request->from_date) {
            $from_date = date('Y-m-d', strtotime(str_replace('/', '-', $request->from_date)));
        } else {
            $from_date = date('Y-m-d');
        }

        if ($request->thru_date) {
            $thru_date = date('Y-m-d', strtotime(str_replace('/', '-', $request->thru_date)));
        } else {
            $thru_date = date('Y-m-d');
        }

        $data = array();

        $show = KopTrxRembug::get_all_transaction($kode_cabang, $kode_petugas, $kode_rembug, $from_date, $thru_date, 0);

        foreach ($show as $sh) {
            $penerimaan = KopTrxRembug::total_cashflow($sh['kode_rembug'], $sh['trx_date'], 'C');
            $penarikan = KopTrxRembug::total_cashflow($sh['kode_rembug'], $sh['trx_date'], 'D');
            $detail = KopTrxRembug::get_detail($sh['id_trx_rembug']);

            if ($sh['verified_by'] <> null) {
                $status = 'Ya';
            } else {
                $status = 'Tidak';
            }

            $data[] = array(
                'nama_rembug' => $sh['nama_rembug'],
                'tanggal_bayar' => $sh['trx_date'],
                'tanggal' => date('Y-m-d', strtotime($sh['created_at'])),
                'nama_petugas' => $sh['nama_pgw'],
                'infaq' => $sh['infaq'],
                'total_penerimaan' => $penerimaan['amount'],
                'total_penarikan' => $penarikan['amount'],
                'status_verifikasi' => $status,
                'detail' => $detail
            );
        }

        $res = array(
            'status' => true,
            'data' => $data
        );

        $response = response()->json($res, 200);

        return $response;
    }

    function list_excel_detail_transaksi_majelis(Request $request)
    {
        $list = new TransaksiMajelisExport($request->branch_code, $request->fa_code, $request->cm_code, $request->from_date, $request->thru_date, 'excel');

        return $list->download('LAPORAN_TRANSAKSI_MAJELIS_' . $request->branch_code . '_' . $request->from_date . '_' . $request->thru_date . '.xlsx');
    }

    function list_pdf_neraca_berjalan(Request $request)
    {
        $kode_cabang = $request->kode_cabang;
        $report_code = $request->report_code;
        $voucher_date = $request->voucher_date;
        $kode_petugas = $request->kode_petugas;

        if ($kode_cabang <> '00000') {
            $branch = KopCabang::where('kode_cabang', $kode_cabang)->first();

            if ($branch <> '00000') {
                $cabang = $branch->nama_cabang;
            } else {
                $cabang = 'SEMUA CABANG';
            }
        } else {
            $cabang = 'SEMUA CABANG';
        }

        if ($voucher_date) {
            $voucher_date = date('Y-m-d', strtotime(str_replace('/', '-', $voucher_date)));
        } else {
            $voucher_date = date('Y-m-d');
        }

        $bulan = substr($voucher_date, 5, 2);

        $startGetClosing = substr($voucher_date, 0, 7) . '-01';
        $startClosing = date('Y-m-d', strtotime($startGetClosing . ' - 1 MONTH'));

        $fromlm = $startClosing;
        $from = $startGetClosing;
        $thru = $voucher_date;

        if ($bulan == '01') {
            $flag_akhir_tahun = 'Y';
        } else {
            $flag_akhir_tahun = 'T';
        }

        $insert_temp = $this->model_laporan_to_pdf->insert_temp_2($kode_cabang, $report_code, $fromlm, $from, $thru, $kode_petugas, $flag_akhir_tahun);
    }

    function list_pdf_gl_inquiry(Request $request)
    {
        $kode_cabang = $request->kode_cabang;
        $kode_gl = $request->kode_gl;

        if ($request->from) {
            $from = date('Y-m-d', strtotime(str_replace('/', '-', $request->from)));
        } else {
            $from = date('Y-m-d');
        }

        if ($request->thru) {
            $thru = date('Y-m-d', strtotime(str_replace('/', '-', $request->thru)));
        } else {
            $thru = date('Y-m-d');
        }

        $saldo_awal = KopTrxGl::get_saldo_awal($kode_gl, $from, $kode_cabang);
        $show = KopTrxGlDetail::get_detail_inquiry($kode_cabang, $kode_gl, $from, $thru);

        if ($kode_cabang <> '~') {
            $branch = KopCabang::where('kode_cabang', $kode_cabang)->first();

            if ($branch <> '00000') {
                $cabang = $branch->nama_cabang;
            } else {
                $cabang = 'SEMUA CABANG';
            }
        } else {
            $cabang = 'SEMUA CABANG';
        }

        $saldo_akhir = $saldo_awal[0]->saldo_awal;
        $total_debit = 0;
        $total_credit = 0;
        $i = 0;

        for ($j = 0; $j <= $show->count(); $j++) {
            if ($j == 0) {
                $data[$j]['nomor'] = '';
                $data[$j]['trx_date'] = '';
                $data[$j]['description'] = 'Saldo Awal';
                $data[$j]['debet'] = 0;
                $data[$j]['credit'] = 0;
                $data[$j]['saldo_akhir'] = (int)$saldo_akhir;
                $data[$j]['id_trx_gl'] = '';
            } else {
                if ($show[$i]['flag_dc'] == 'C') {
                    if ($show[$i]['default_saldo'] == 'C') {
                        $saldo_akhir += $show[$i]['amount'];
                    } else {
                        $saldo_akhir -= $show[$i]['amount'];
                    }
                }

                if ($show[$i]['flag_dc'] == 'D') {
                    if ($show[$i]['default_saldo'] == 'D') {
                        $saldo_akhir += $show[$i]['amount'];
                    } else {
                        $saldo_akhir -= $show[$i]['amount'];
                    }
                }

                $data[$j]['nomor'] = $i + 1;
                $data[$j]['trx_date'] = date('d-m-Y', strtotime($show[$i]['voucher_date']));
                $data[$j]['description'] = $show[$i]['description'];
                $data[$j]['debet'] = (int)$show[$i]['debet'];
                $data[$j]['credit'] = (int)$show[$i]['credit'];
                $data[$j]['saldo_akhir'] = (int)$saldo_akhir;
                $data[$j]['id_trx_gl'] = $show[$i]['id_trx_gl'];

                $total_debit  += $show[$i]['debet'];
                $total_credit += $show[$i]['credit'];

                $i++;
            }
        }

        $res = array(
            'status' => true,
            'nama_cabang' => $cabang,
            'from_date' => $from,
            'thru_date' => $thru,
            'data' => $data
        );

        $response = response()->json($res, 200);

        return $response;
    }

    function list_excel_gl_inquiry(Request $request)
    {
        $list = new BukuBesarExport($request->kode_cabang, $request->kode_gl, $request->from_date, $request->thru_date, 'excel');

        return $list->download('LAPORAN_BUKU_BESAR_' . $request->kode_cabang . '_' . $request->kode_gl . '_' . $request->from_date . '_' . $request->thru_date . '.xlsx');
    }

    function list_csv_gl_inquiry(Request $request)
    {
        $list = new BukuBesarExport($request->kode_cabang, $request->kode_gl, $request->from_date, $request->thru_date, 'csv');

        return $list->download('LAPORAN_BUKU_BESAR_' . $request->kode_cabang . '_' . $request->kode_gl . '_' . $request->from_date . '_' . $request->thru_date . '.csv');
    }
}
