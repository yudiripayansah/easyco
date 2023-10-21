<?php

namespace App\Http\Controllers;

use App\Exports\BukuBesarExport;
use App\Exports\JurnalTransaksiExport;
use App\Exports\KartuAngsuranExport;
use App\Exports\KasPetugasExport;
use App\Exports\ListAnggotaKeluarExport;
use App\Exports\ListAnggotaMasukExport;
use App\Exports\ListBukaTabunganExport;
use App\Exports\ListKolektibilitasExport;
use App\Exports\ListPelunasanExport;
use App\Exports\ListPengajuanExport;
use App\Exports\ListRegisAkadExport;
use App\Exports\ListPencairanExport;
use App\Exports\ListSaldoAnggotaExport;
use App\Exports\ListSaldoKasPetugasExport;
use App\Exports\ListSaldoOutstandingExport;
use App\Exports\ListSaldoTabunganExport;
use App\Exports\RekapOutstandingExport;
use App\Exports\RekapPencairanExport;
use App\Exports\RekapPengajuanExport;
use App\Exports\RekapSaldoAnggotaExport;
use App\Exports\StatementTabunganExport;
use App\Exports\TransaksiMajelisExport;
use App\Models\KopAnggota;
use App\Models\KopAnggotaMutasi;
use App\Models\KopCabang;
use App\Models\KopKasPetugasTemporary;
use App\Models\KopPegawai;
use App\Models\KopPelunasan;
use App\Models\KopPembiayaan;
use App\Models\KopPengajuan;
use App\Models\KopPrdTabungan;
use App\Models\KopRembug;
use App\Models\KopTabungan;
use App\Models\KopTrxAnggota;
use App\Models\KopTrxGl;
use App\Models\KopTrxGlDetail;
use App\Models\KopTrxKasPetugas;
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
        $list = new ListSaldoAnggotaExport($request->kode_cabang, $request->kode_petugas, $request->kode_rembug, $request->from_date, $request->thru_date, 'excel');

        if ($request->kode_cabang <> '~') {
            $branch = KopCabang::where('kode_cabang', $request->kode_cabang)->first();
            $cabang = str_replace(' ', '_', $branch->nama_cabang);
        } else {
            $cabang = 'SEMUA_CABANG';
        }

        if ($request->kode_petugas <> '~') {
            $fa = KopPegawai::where('kode_pgw', $request->kode_petugas)->first();
            $petugas = str_replace(' ', '_', $fa->nama_pgw);
        } else {
            $petugas = 'SEMUA_PETUGAS';
        }

        return $list->download('LAPORAN_SALDO_ANGGOTA_' . $cabang . '_' . $petugas . '.xlsx');
    }

    function list_csv_saldo_anggota(Request $request)
    {
        $list = new ListSaldoAnggotaExport($request->kode_cabang, $request->kode_petugas, $request->kode_rembug, $request->from_date, $request->thru_date, 'csv');

        if ($request->kode_cabang <> '~') {
            $branch = KopCabang::where('kode_cabang', $request->kode_cabang)->first();
            $cabang = str_replace(' ', '_', $branch->nama_cabang);
        } else {
            $cabang = 'SEMUA_CABANG';
        }

        if ($request->kode_petugas <> '~') {
            $fa = KopPegawai::where('kode_pgw', $request->kode_petugas)->first();
            $petugas = str_replace(' ', '_', $fa->nama_pgw);
        } else {
            $petugas = 'SEMUA_CABANG';
        }

        return $list->download('LAPORAN_SALDO_ANGGOTA_' . $cabang . '_' . $petugas . '.csv');
    }

    function list_excel_saldo_outstanding(Request $request)
    {
        $list = new ListSaldoOutstandingExport($request->kode_cabang, $request->kode_rembug, $request->kode_petugas, 'excel');

        if ($request->kode_cabang <> 'null') {
            $branch = KopCabang::where('kode_cabang', $request->kode_cabang)->first();
            $cabang = str_replace(' ', '_', $branch->nama_cabang);
        } else {
            $cabang = 'SEMUA_CABANG';
        }

        if ($request->kode_rembug <> 'null') {
            $cm = KopRembug::where('kode_rembug', $request->kode_rembug)->first();
            $rembug = str_replace(' ', '_', $cm->nama_rembug);
        } else {
            $rembug = 'SEMUA_REMBUG';
        }

        return $list->download('LAPORAN_SALDO_OUTSTANDING_' . $cabang . '_' . $rembug . '.xlsx');
    }

    function list_csv_saldo_outstanding(Request $request)
    {
        $list = new ListSaldoOutstandingExport($request->kode_cabang, $request->kode_rembug, $request->kode_petugas, 'csv');

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
            'no_anggota' => $getAnggota['no_anggota'],
            'nama_anggota' => $getAnggota['nama_anggota'],
            'simpok' => (int) $getAnggota['simpok'],
            'simwa' => (int) $getAnggota['simwa'],
            'simsuk' => (int) $getAnggota['simsuk'],
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
                } else if ($pembiayaan['status_rekening'] == 2) {
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

    function anggota_keluar(Request $request)
    {
        $kode_cabang = $request->kode_cabang;
        $kode_rembug = $request->kode_rembug;

        if ($kode_cabang <> '~' and $kode_cabang <> '00000' and !empty($kode_cabang) and $kode_cabang <> null) {
            $branch = KopCabang::where('kode_cabang', $kode_cabang)->first();
            $cabang = $branch->nama_cabang;
        } else {
            $cabang = 'SEMUA CABANG';
        }

        if ($kode_rembug <> '~' and $kode_rembug <> '00000' and !empty($kode_rembug) and $kode_rembug <> null) {
            $cm = KopRembug::where('kode_rembug', $kode_rembug)->first();
            $rembug = $cm->nama_rembug;
        } else {
            $rembug = 'SEMUA MAJLIS';
        }

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

        $show = KopAnggotaMutasi::get_anggota_keluar($kode_cabang, $kode_rembug, $from_date, $thru_date);

        $data = array();

        foreach ($show as $sh) {
            if ($sh['alasan_mutasi'] == 1) {
                $alasan = 'Meninggal';
            } else if ($sh['alasan_mutasi'] == 2) {
                $alasan = 'Karakter';
            } else if ($sh['alasan_mutasi'] == 3) {
                $alasan = 'Pindah Lembaga Lain';
            } else if ($sh['alasan_mutasi'] == 4) {
                $alasan = 'Tidak diijinkan Pasangan';
            } else if ($sh['alasan_mutasi'] == 5) {
                $alasan = 'Simpanan Kurang';
            } else if ($sh['alasan_mutasi'] == 6) {
                $alasan = 'Kondisi Keluarga';
            } else if ($sh['alasan_mutasi'] == 7) {
                $alasan = 'Pindah Alamat';
            } else if ($sh['alasan_mutasi'] == 8) {
                $alasan = 'Tidak Setuju Keputusan Lembaga';
            } else if ($sh['alasan_mutasi'] == 9) {
                $alasan = 'Usia / Jompo';
            } else if ($sh['alasan_mutasi'] == 10) {
                $alasan = 'Sakit';
            } else if ($sh['alasan_mutasi'] == 11) {
                $alasan = 'Kumpulan Bubar';
            } else if ($sh['alasan_mutasi'] == 12) {
                $alasan = 'Tidak Punya Waktu';
            } else if ($sh['alasan_mutasi'] == 13) {
                $alasan = 'Kerja';
            } else if ($sh['alasan_mutasi'] == 14) {
                $alasan = 'Cerai';
            } else if ($sh['alasan_mutasi'] == 15) {
                $alasan = 'Pembiayaan Bermasalah';
            } else if ($sh['alasan_mutasi'] == 16) {
                $alasan = 'Usaha Sudah Berkembang';
            } else if ($sh['alasan_mutasi'] == 17) {
                $alasan = 'Tidak Mau Kumpulan';
            } else if ($sh['alasan_mutasi'] == 18) {
                $alasan = 'Batal Pembiayaan (Anggota baru)';
            } else {
                $alasan = 'Migrasi Anggota Individu';
            }

            $data[] = array(
                'nama_cabang' => $sh['nama_cabang'],
                'nama_rembug' => $sh['nama_rembug'],
                'no_anggota' => $sh['no_anggota'],
                'nama_anggota' => $sh['nama_anggota'],
                'alasan_mutasi' => $alasan,
                'keterangan_mutasi' => $sh['keterangan_mutasi'],
                'tanggal_mutasi' => date('d/m/Y', strtotime(str_replace('-', '/', $sh['tanggal_mutasi']))),
                'saldo_pokok' => (int) $sh['saldo_pokok'],
                'saldo_margin' => (int) $sh['saldo_margin'],
                'saldo_catab' => (int) $sh['saldo_catab'],
                'saldo_minggon' => (int) $sh['saldo_minggon'],
                'saldo_sukarela' => (int) $sh['saldo_sukarela'],
                'saldo_tab_berencana' => (int) $sh['saldo_tab_berencana'],
                'saldo_deposito' => (int) $sh['saldo_deposito'],
                'saldo_simpok' => (int) $sh['saldo_simpok'],
                'saldo_simwa' => (int) $sh['saldo_simwa'],
                'bonus_bagihasil' => (int) $sh['bonus_bagihasil'],
                'penarikan_sukarela' => (int) ($sh['setoran_tambahan'] + $sh['penarikan_sukarela']),
                'nama_petugas' => $sh['nama_pgw']
            );
        }

        $res = array(
            'status' => true,
            'nama_cabang' => $cabang,
            'from_date' => $from_date,
            'thru_date' => $thru_date,
            'data' => $data
        );

        $response = response()->json($res, 200);

        return $response;
    }

    function list_excel_anggota_keluar(Request $request)
    {
        $kode_cabang = $request->kode_cabang;
        $kode_rembug = $request->kode_rembug;

        if ($kode_cabang <> '~' and $kode_cabang <> '00000' and !empty($kode_cabang) and $kode_cabang <> null) {
            $branch = KopCabang::where('kode_cabang', $kode_cabang)->first();
            $cabang = $branch->nama_cabang;
        } else {
            $cabang = 'SEMUA CABANG';
        }

        if ($kode_rembug <> '~' and $kode_rembug <> '00000' and !empty($kode_rembug) and $kode_rembug <> null) {
            $cm = KopRembug::where('kode_rembug', $kode_rembug)->first();
            $rembug = $cm->nama_rembug;
        } else {
            $rembug = 'SEMUA MAJLIS';
        }

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

        $list = new ListAnggotaKeluarExport($kode_cabang, $kode_rembug, $from_date, $thru_date, 'excel');

        return $list->download('LAPORAN_ANGGOTA_KELUAR_' . $cabang . '_' . $from_date . '_' . $thru_date . '.xlsx');
    }

    function list_csv_anggota_keluar(Request $request)
    {
        $kode_cabang = $request->kode_cabang;
        $kode_rembug = $request->kode_rembug;

        if ($kode_cabang <> '~' and $kode_cabang <> '00000' and !empty($kode_cabang) and $kode_cabang <> null) {
            $branch = KopCabang::where('kode_cabang', $kode_cabang)->first();
            $cabang = $branch->nama_cabang;
        } else {
            $cabang = 'SEMUA CABANG';
        }

        if ($kode_rembug <> '~' and $kode_rembug <> '00000' and !empty($kode_rembug) and $kode_rembug <> null) {
            $cm = KopRembug::where('kode_rembug', $kode_rembug)->first();
            $rembug = $cm->nama_rembug;
        } else {
            $rembug = 'SEMUA MAJLIS';
        }

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

        $list = new ListAnggotaKeluarExport($kode_cabang, $kode_rembug, $from_date, $thru_date, 'csv');

        return $list->download('LAPORAN_ANGGOTA_KELUAR_' . $cabang . '_' . $from_date . '_' . $thru_date . '.csv');
    }

    function list_excel_kolektibilitas(Request $request)
    {
        $list = new ListKolektibilitasExport($request->kode_cabang, $request->tanggal_hitung, 'excel');

        if ($request->kode_cabang <> '00000') {
            $branch = KopCabang::where('kode_cabang', $request->kode_cabang)->first();
            $cabang = str_replace(' ', '_', $branch->nama_cabang);
        } else {
            $cabang = 'SEMUA_CABANG';
        }

        if ($request->tanggal_hitung) {
            $tanggal_hitung = date('Y-m-d', strtotime(str_replace('/', '-', $request->tanggal_hitung)));
        } else {
            $tanggal_hitung = date('Y-m-d');
        }

        return $list->download('LAPORAN_KOLEKTIBILITAS_' . $cabang . '_' . $tanggal_hitung . '.xlsx');
    }

    function list_csv_kolektibilitas(Request $request)
    {
        $list = new ListKolektibilitasExport($request->kode_cabang, $request->tanggal_hitung, 'csv');

        if ($request->kode_cabang <> '00000') {
            $branch = KopCabang::where('kode_cabang', $request->kode_cabang)->first();
            $cabang = str_replace(' ', '_', $branch->nama_cabang);
        } else {
            $cabang = 'SEMUA_CABANG';
        }

        if ($request->tanggal_hitung) {
            $tanggal_hitung = date('Y-m-d', strtotime(str_replace('/', '-', $request->tanggal_hitung)));
        } else {
            $tanggal_hitung = date('Y-m-d');
        }

        return $list->download('LAPORAN_KOLEKTIBILITAS_' . $cabang . '_' . $tanggal_hitung . '.csv');
    }

    function statement_tabungan(Request $request)
    {
        $no_anggota = $request->no_anggota;
        $jenis_tabungan = $request->jenis_tabungan;
        $no_rekening = $request->no_rekening;
        $from_date = $request->from_date;
        $thru_date = $request->thru_date;

        $from_date = date('Y-m-d', strtotime(str_replace('/', '-', $from_date)));
        $thru_date = date('Y-m-d', strtotime(str_replace('/', '-', $thru_date)));

        $nama = KopAnggota::get_profile($no_anggota);

        $data = array();

        if ($jenis_tabungan == 1) {
            // Tabungan Sukarela
            $get_credit = KopTrxAnggota::get_credit_member($no_anggota, [13], $from_date);
            $get_debet = KopTrxAnggota::get_debet_member($no_anggota, [22], $from_date);
            $get_pinbuk = KopTrxAnggota::get_pinbuk_member($no_anggota, [41, 42, 43, 44], $from_date);

            $credit = (isset($get_credit->amount) ? $get_credit->amount : 0);
            $debet = (isset($get_debet->amount) ? $get_debet->amount : 0);
            $pinbuk = (isset($get_pinbuk->amount) ? $get_pinbuk->amount : 0);

            $saldo_awal = ($credit + $pinbuk) - $debet;
            $saldo_akhir = $saldo_awal;

            $get_history = KopTrxAnggota::get_history_member($no_anggota, [13, 22, 41, 42, 43, 44], $from_date, $thru_date);
        } elseif ($jenis_tabungan == 2) {
            // Tabungan Berencana
            $get_credit = KopTrxAnggota::get_history_dc_member($no_rekening, 'C', $from_date);
            $get_debet = KopTrxAnggota::get_history_dc_member($no_rekening, 'D', $from_date);
            $get_pinbuk = KopTrxAnggota::get_pinbuk_member($no_anggota, [43, 44], $from_date);

            $credit = (isset($get_credit->amount) ? $get_credit->amount : 0);
            $debet = (isset($get_debet->amount) ? $get_debet->amount : 0);
            $pinbuk = (isset($get_pinbuk->amount) ? $get_pinbuk->amount : 0);

            $saldo_awal = $credit - ($debet + $pinbuk);
            $saldo_akhir = $saldo_awal;

            $get_history = KopTrxAnggota::get_history_savingplan($no_rekening, $from_date, $thru_date);
            $get_history_pinbuk = KopTrxAnggota::get_history_member($no_anggota, [43, 44], $from_date, $thru_date);

            for ($j = 0; $j < count($get_history_pinbuk); $j++) {
                $saldo_akhir += 0 - $get_history_pinbuk[$j]->amount;

                $data[] = array(
                    'trx_date' => $get_history_pinbuk[$j]->trx_date,
                    'setor' => 0,
                    'tarik' => (int) $get_history_pinbuk[$j]->amount,
                    'saldo_akhir' => (int) $saldo_akhir,
                    'keterangan' => $get_history_pinbuk[$j]->description
                );
            }
        } else {
            // Simpanan Wajib / Minggon
            $get_credit = KopTrxAnggota::get_credit_member($no_anggota, [12, 34], $from_date);
            $get_debet = 0;
            $get_pinbuk = KopTrxAnggota::get_pinbuk_member($no_anggota, [42], $from_date);

            $credit = (isset($get_credit->amount) ? $get_credit->amount : 0);
            $debet = 0;
            $pinbuk = (isset($get_pinbuk->amount) ? $get_pinbuk->amount : 0);

            $saldo_awal = ($credit) - ($debet + $pinbuk);
            $saldo_akhir = $saldo_awal;

            $get_history = KopTrxAnggota::get_history_member($no_anggota, [12, 34, 42], $from_date, $thru_date);
        }

        for ($i = 0; $i < count($get_history); $i++) {
            $trx_date = $get_history[$i]->trx_date;
            $amount = $get_history[$i]->amount;
            $flag_debet_credit = $get_history[$i]->flag_debet_credit;
            $description = $get_history[$i]->description;
            $trx_type = $get_history[$i]->trx_type;

            if ($jenis_tabungan == 1) {
                if ($trx_type == 41 or $trx_type == 42 or $trx_type == 43 or $trx_type == 44) {
                    $flag_debet_credit = 'C';
                }
            }

            if ($flag_debet_credit == 'C') {
                $history_credit = $amount;
                $setor = $history_credit;
                $tarik = 0;
            } else {
                $history_debet = $amount;
                $setor = 0;
                $tarik = $history_debet;
            }

            $saldo_akhir += $setor - $tarik;

            $data[] = array(
                'trx_date' => $trx_date,
                'setor' => (int) $setor,
                'tarik' => (int) $tarik,
                'saldo_akhir' => (int) $saldo_akhir,
                'keterangan' => $description
            );
        }

        $res = array(
            'status' => true,
            'nama' => $nama->nama_anggota,
            'from_date' => $from_date,
            'thru_date' => $thru_date,
            'saldo_awal' => (int) $saldo_awal,
            'data' => $data
        );

        $response = response()->json($res, 200);

        return $response;
    }

    function list_excel_statement_tabungan(Request $request)
    {
        $from_date = date('Y-m-d', strtotime(str_replace('/', '-', $request->from_date)));
        $thru_date = date('Y-m-d', strtotime(str_replace('/', '-', $request->thru_date)));

        $list = new StatementTabunganExport($request->no_anggota, $request->jenis_tabungan, $request->no_rekening, $request->from_date, $request->thru_date, 'excel');

        return $list->download('LAPORAN_STATEMENT_TABUNGAN_' . $request->no_anggota . '_' . $from_date . '_' . $thru_date . '.xlsx');
    }

    function list_csv_statement_tabungan(Request $request)
    {
        $from_date = date('Y-m-d', strtotime(str_replace('/', '-', $request->from_date)));
        $thru_date = date('Y-m-d', strtotime(str_replace('/', '-', $request->thru_date)));

        $list = new StatementTabunganExport($request->no_anggota, $request->jenis_tabungan, $request->no_rekening, $request->from_date, $request->thru_date, 'csv');

        return $list->download('LAPORAN_STATEMENT_TABUNGAN_' . $request->no_anggota . '_' . $from_date . '_' . $thru_date . '.csv');
    }

    function list_pelunasan(Request $request)
    {
        $kode_cabang = $request->kode_cabang;
        $kode_petugas = $request->kode_petugas;
        $kode_rembug = $request->kode_rembug;

        if ($kode_cabang <> '~' and $kode_cabang <> '00000' and !empty($kode_cabang) and $kode_cabang <> null) {
            $branch = KopCabang::where('kode_cabang', $kode_cabang)->first();
            $cabang = $branch->nama_cabang;
        } else {
            $cabang = 'SEMUA CABANG';
        }

        if ($kode_petugas <> '~' and $kode_petugas <> '00000' and !empty($kode_petugas) and $kode_petugas <> null) {
            $fa = KopPegawai::where('kode_pgw', $kode_petugas)->first();
            $petugas = $fa->nama_pgw;
        } else {
            $petugas = 'SEMUA PETUGAS';
        }

        if ($kode_rembug <> '~' and $kode_rembug <> '00000' and !empty($kode_rembug) and $kode_rembug <> null) {
            $cm = KopRembug::where('kode_rembug', $kode_rembug)->first();
            $rembug = $cm->nama_rembug;
        } else {
            $rembug = 'SEMUA MAJLIS';
        }

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

        $show = KopPelunasan::get_pelunasan($kode_cabang, $kode_petugas, $kode_rembug, $from_date, $thru_date);

        $data = array();

        foreach ($show as $sh) {
            if ($sh['periode_jangka_waktu'] == 0) {
                $periode = 'Hari';
            } else if ($sh['periode_jangka_waktu'] == 1) {
                $periode = 'Minggu';
            } else if ($sh['periode_jangka_waktu'] == 2) {
                $periode = 'Bulan';
            } else {
                $periode = 'Tempo';
            }

            $data[] = array(
                'tanggal_pelunasan' => date('d/m/Y', strtotime(str_replace('-', '/', $sh['tanggal_pelunasan']))),
                'no_rekening' => $sh['no_rekening'],
                'nama_anggota' => $sh['nama_anggota'],
                'nama_rembug' => $sh['nama_rembug'],
                'pokok' => (int) $sh['pokok'],
                'margin' => (int) $sh['margin'],
                'jangka_waktu' => $sh['jangka_waktu'],
                'periode_jangka_waktu' => $periode,
                'tanggal_jtempo' => date('d/m/Y', strtotime(str_replace('-', '/', $sh['tanggal_jtempo']))),
                'counter_angsuran' => $sh['counter_angsuran'],
                'saldo_pokok' => (int) $sh['saldo_pokok'],
                'saldo_margin' => (int) $sh['saldo_margin'],
                'saldo_catab' => (int) $sh['saldo_catab'],
                'potongan_margin' => (int) $sh['potongan_margin'],
                'nama_pgw' => $sh['nama_pgw']
            );
        }

        $res = array(
            'status' => true,
            'nama_cabang' => $cabang,
            'nama_petugas' => $petugas,
            'nama_rembug' => $rembug,
            'from_date' => $from_date,
            'thru_date' => $thru_date,
            'data' => $data
        );

        $response = response()->json($res, 200);

        return $response;
    }

    function list_excel_pelunasan(Request $request)
    {
        if ($request->kode_cabang <> '~' and $request->kode_cabang <> '00000' and !empty($request->kode_cabang) and $request->kode_cabang <> null) {
            $branch = KopCabang::where('kode_cabang', $request->kode_cabang)->first();
            $cabang = $branch->nama_cabang;
        } else {
            $cabang = 'SEMUA CABANG';
        }

        if ($request->kode_petugas <> '~' and $request->kode_petugas <> '00000' and !empty($request->kode_petugas) and $request->kode_petugas <> null) {
            $fa = KopPegawai::where('kode_pgw', $request->kode_petugas)->first();
            $petugas = $fa->nama_pgw;
        } else {
            $petugas = 'SEMUA PETUGAS';
        }

        if ($request->kode_rembug <> '~' and $request->kode_rembug <> '00000' and !empty($request->kode_rembug) and $request->kode_rembug <> null) {
            $cm = KopRembug::where('kode_rembug', $request->kode_rembug)->first();
            $rembug = $cm->nama_rembug;
        } else {
            $rembug = 'SEMUA MAJLIS';
        }

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

        $list = new ListPelunasanExport($request->kode_cabang, $request->kode_petugas, $request->kode_rembug, $from_date, $thru_date, 'excel');

        return $list->download('LAPORAN_PELUNASAN_' . $cabang . '_' . $petugas . '_' . $from_date . '_' . $thru_date . '.xlsx');
    }

    function list_csv_pelunasan(Request $request)
    {
        if ($request->kode_cabang <> '~' and $request->kode_cabang <> '00000' and !empty($request->kode_cabang) and $request->kode_cabang <> null) {
            $branch = KopCabang::where('kode_cabang', $request->kode_cabang)->first();
            $cabang = $branch->nama_cabang;
        } else {
            $cabang = 'SEMUA CABANG';
        }

        if ($request->kode_petugas <> '~' and $request->kode_petugas <> '00000' and !empty($request->kode_petugas) and $request->kode_petugas <> null) {
            $fa = KopPegawai::where('kode_pgw', $request->kode_petugas)->first();
            $petugas = $fa->nama_pgw;
        } else {
            $petugas = 'SEMUA PETUGAS';
        }

        if ($request->kode_rembug <> '~' and $request->kode_rembug <> '00000' and !empty($request->kode_rembug) and $request->kode_rembug <> null) {
            $cm = KopRembug::where('kode_rembug', $request->kode_rembug)->first();
            $rembug = $cm->nama_rembug;
        } else {
            $rembug = 'SEMUA MAJLIS';
        }

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

        $list = new ListPelunasanExport($request->kode_cabang, $request->kode_petugas, $request->kode_rembug, $from_date, $thru_date, 'csv');

        return $list->download('LAPORAN_PELUNASAN_' . $cabang . '_' . $petugas . '_' . $from_date . '_' . $thru_date . '.csv');
    }

    function list_saldo_tabungan(Request $request)
    {
        $page = $request->page;
        $perPage = $request->perPage;
        $kode_cabang = $request->kode_cabang;
        $kode_produk = $request->kode_produk;

        if ($page) {
            $page = $request->page;
        } else {
            $page = 1;
        }

        if ($perPage) {
            $perPage = $request->perPage;
        } else {
            $perPage = '~';
        }

        if ($page > 1) {
            $offset = ($page - 1) * $perPage;
        } else {
            $offset = 0;
        }

        if ($kode_cabang <> '~' and $kode_cabang <> '00000' and !empty($kode_cabang) and $kode_cabang <> null) {
            $branch = KopCabang::where('kode_cabang', $kode_cabang)->first();
            $cabang = $branch->nama_cabang;
        } else {
            $cabang = 'SEMUA CABANG';
        }

        if ($kode_produk <> '~' and $kode_produk <> '00000' and !empty($kode_produk) and $kode_produk <> null) {
            $product = KopPrdTabungan::where('kode_produk', $kode_produk)->first();
            $tabungan = $product->nama_produk;
        } else {
            $tabungan = 'SEMUA PRODUK';
        }

        $show = KopTabungan::get_report_tabungan($kode_cabang, $kode_produk, $perPage, $offset, 1);
        $total = KopTabungan::get_report_tabungan($kode_cabang, $kode_produk, $perPage, $offset, 0)->count();

        if ($perPage != '~') {
            $totalPage = ceil($total / $perPage);
        } else {
            $totalPage = 1;
        }

        $data = array();

        foreach ($show as $sh) {
            $data[] = array(
                'no_rekening' => $sh->no_rekening,
                'nama_rembug' => $sh->nama_rembug,
                'nama_pgw' => $sh->nama_pgw,
                'no_anggota' => $sh->no_anggota,
                'nama_anggota' => $sh->nama_anggota,
                'nama_produk' => $sh->nama_produk,
                'saldo' => (int) $sh->saldo
            );
        }

        $res = array(
            'status' => true,
            'nama_cabang' => $cabang,
            'nama_produk' => $tabungan,
            'page' => $page,
            'perPage' => $perPage,
            'total' => $total,
            'totalPage' => $totalPage,
            'data' => $data
        );

        $response = response()->json($res, 200);

        return $response;
    }

    function list_excel_saldo_tabungan(Request $request)
    {
        if ($request->kode_cabang <> '~' and $request->kode_cabang <> '00000' and !empty($request->kode_cabang) and $request->kode_cabang <> null) {
            $branch = KopCabang::where('kode_cabang', $request->kode_cabang)->first();
            $cabang = $branch->nama_cabang;
        } else {
            $cabang = 'SEMUA CABANG';
        }

        if ($request->kode_produk <> '~' and $request->kode_produk <> '00000' and !empty($request->kode_produk) and $request->kode_produk <> null) {
            $product = KopPrdTabungan::where('kode_produk', $request->kode_produk)->first();
            $tabungan = $product->nama_produk;
        } else {
            $tabungan = 'SEMUA PRODUK';
        }

        $list = new ListSaldoTabunganExport($request->kode_cabang, $request->kode_produk, 'excel');

        return $list->download('LAPORAN_PELUNASAN_' . $cabang . '_' . $tabungan . '.xlsx');
    }

    function list_csv_saldo_tabungan(Request $request)
    {
        if ($request->kode_cabang <> '~' and $request->kode_cabang <> '00000' and !empty($request->kode_cabang) and $request->kode_cabang <> null) {
            $branch = KopCabang::where('kode_cabang', $request->kode_cabang)->first();
            $cabang = $branch->nama_cabang;
        } else {
            $cabang = 'SEMUA CABANG';
        }

        if ($request->kode_produk <> '~' and $request->kode_produk <> '00000' and !empty($request->kode_produk) and $request->kode_produk <> null) {
            $product = KopPrdTabungan::where('kode_produk', $request->kode_produk)->first();
            $tabungan = $product->nama_produk;
        } else {
            $tabungan = 'SEMUA PRODUK';
        }

        $list = new ListSaldoTabunganExport($request->kode_cabang, $request->kode_produk, 'csv');

        return $list->download('LAPORAN_PELUNASAN_' . $cabang . '_' . $tabungan . '.csv');
    }

    function list_buka_tabungan(Request $request)
    {
        $kode_cabang = $request->kode_cabang;
        $kode_produk = $request->kode_produk;
        $from_date = $request->from_date;
        $thru_date = $request->thru_date;

        if ($kode_cabang <> '~' and $kode_cabang <> '00000' and !empty($kode_cabang) and $kode_cabang <> null) {
            $branch = KopCabang::where('kode_cabang', $kode_cabang)->first();
            $cabang = $branch->nama_cabang;
        } else {
            $cabang = 'SEMUA CABANG';
        }

        if ($kode_produk <> '~' and $kode_produk <> '00000' and !empty($kode_produk) and $kode_produk <> null) {
            $product = KopPrdTabungan::where('kode_produk', $kode_produk)->first();
            $tabungan = $product->nama_produk;
        } else {
            $tabungan = 'SEMUA PRODUK';
        }

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

        $show = KopTabungan::get_report_buka_tabungan($kode_cabang, $kode_produk, $from_date, $thru_date);

        $data = array();

        foreach ($show as $sh) {
            if ($sh->periode_setoran == 0) {
                $periode = 'Hari';
            } elseif ($sh->periode_setoran == 1) {
                $periode = 'Minggu';
            } else {
                $periode = 'Bulan';
            }

            $data[] = array(
                'nama_cabang' => $sh->nama_cabang,
                'tanggal_buka' => date('d/m/Y', strtotime(str_replace('-', '/', $sh->tanggal_buka))),
                'no_rekening' => $sh->no_rekening,
                'nama_anggota' => $sh->nama_anggota,
                'nama_produk' => $sh->nama_produk,
                'jangka_waktu' => $sh->jangka_waktu . ' ' . $periode,
                'saldo' => (int) $sh->saldo
            );
        }

        $res = array(
            'status' => true,
            'nama_cabang' => $cabang,
            'nama_produk' => $tabungan,
            'from_date' => $from_date,
            'thru_date' => $thru_date,
            'data' => $data
        );

        $response = response()->json($res, 200);

        return $response;
    }

    function list_excel_buka_tabungan(Request $request)
    {
        $kode_cabang = $request->kode_cabang;
        $kode_produk = $request->kode_produk;
        $from_date = $request->from_date;
        $thru_date = $request->thru_date;

        if ($kode_cabang <> '~' and $kode_cabang <> '00000' and !empty($kode_cabang) and $kode_cabang <> null) {
            $branch = KopCabang::where('kode_cabang', $kode_cabang)->first();
            $cabang = $branch->nama_cabang;
        } else {
            $cabang = 'SEMUA CABANG';
        }

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

        $list = new ListBukaTabunganExport($kode_cabang, $kode_produk, $from_date, $thru_date, 'excel');

        return $list->download('LAPORAN_BUKA_TABUNGAN_' . $cabang . '_' . $from_date . '_' . $thru_date . '.xlsx');
    }

    function list_csv_buka_tabungan(Request $request)
    {
        $kode_cabang = $request->kode_cabang;
        $kode_produk = $request->kode_produk;
        $from_date = $request->from_date;
        $thru_date = $request->thru_date;

        if ($kode_cabang <> '~' and $kode_cabang <> '00000' and !empty($kode_cabang) and $kode_cabang <> null) {
            $branch = KopCabang::where('kode_cabang', $kode_cabang)->first();
            $cabang = $branch->nama_cabang;
        } else {
            $cabang = 'SEMUA CABANG';
        }

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

        $list = new ListBukaTabunganExport($kode_cabang, $kode_produk, $from_date, $thru_date, 'csv');

        return $list->download('LAPORAN_BUKA_TABUNGAN_' . $cabang . '_' . $from_date . '_' . $thru_date . '.csv');
    }

    function list_saldo_kas_petugas(Request $request)
    {
        $kode_cabang = $request->kode_cabang;
        $tanggal = $request->tanggal;
        $created_by = substr(md5(rand()), 0, 30);

        if ($kode_cabang <> '~' and $kode_cabang <> '00000' and !empty($kode_cabang) and $kode_cabang <> null) {
            $branch = KopCabang::where('kode_cabang', $kode_cabang)->first();
            $cabang = $branch->nama_cabang;
        } else {
            $cabang = 'SEMUA CABANG';
        }

        if ($tanggal <> '~' and !empty($tanggal) and $tanggal <> null) {
            $tanggal = date('Y-m-d', strtotime(str_replace('/', '-', $tanggal)));
        } else {
            $tanggal = date('Y-m-d');
        }

        KopTrxKasPetugas::fn_saldo_kas($kode_cabang, $tanggal, $created_by);

        $show = KopKasPetugasTemporary::get_cash_history($kode_cabang, $tanggal, $created_by);

        $data = array();

        $total_saldo_awal = 0;
        $total_saldo_akhir = 0;

        foreach ($show as $sh) {
            $data[] = array(
                'kode_kas_petugas' => $sh->kode_kas_petugas,
                'nama_kas_petugas' => $sh->nama_kas_petugas,
                'saldo_awal' => (int) $sh->saldo_awal,
                'mutasi_debet' => (int) $sh->mutasi_debet,
                'mutasi_credit' => (int) $sh->mutasi_credit,
                'saldo_akhir' => (int) $sh->saldo_akhir
            );

            $total_saldo_awal += $sh->saldo_awal;
            $total_saldo_akhir += $sh->saldo_akhir;
        }

        $get = KopKasPetugasTemporary::where('created_by', $created_by)->first();
        if ($get) {
            KopKasPetugasTemporary::find($get->id)->forceDelete();
        }

        $res = array(
            'status' => true,
            'nama_cabang' => $cabang,
            'tanggal' => $tanggal,
            'total_saldo_awal' => $total_saldo_awal,
            'total_saldo_akhir' => $total_saldo_akhir,
            'data' => $data
        );

        $response = response()->json($res, 200);

        return $response;
    }

    function list_excel_saldo_kas_petugas(Request $request)
    {
        $kode_cabang = $request->kode_cabang;
        $tanggal = $request->tanggal;
        $created_by = substr(md5(rand()), 0, 30);

        if ($kode_cabang <> '~' and $kode_cabang <> '00000' and !empty($kode_cabang) and $kode_cabang <> null) {
            $branch = KopCabang::where('kode_cabang', $kode_cabang)->first();
            $cabang = $branch->nama_cabang;
        } else {
            $cabang = 'SEMUA CABANG';
        }

        if ($tanggal <> '~' and !empty($tanggal) and $tanggal <> null) {
            $tanggal = date('Y-m-d', strtotime(str_replace('/', '-', $tanggal)));
        } else {
            $tanggal = date('Y-m-d');
        }

        $list = new ListSaldoKasPetugasExport($kode_cabang, $tanggal, $created_by, 'excel');

        return $list->download('LAPORAN_SALDO_KAS_PETUGAS_' . $cabang . '_' . $tanggal . '.xlsx');
    }

    function list_csv_saldo_kas_petugas(Request $request)
    {
        $kode_cabang = $request->kode_cabang;
        $tanggal = $request->tanggal;
        $created_by = substr(md5(rand()), 0, 30);

        if ($kode_cabang <> '~' and $kode_cabang <> '00000' and !empty($kode_cabang) and $kode_cabang <> null) {
            $branch = KopCabang::where('kode_cabang', $kode_cabang)->first();
            $cabang = $branch->nama_cabang;
        } else {
            $cabang = 'SEMUA CABANG';
        }

        if ($tanggal <> '~' and !empty($tanggal) and $tanggal <> null) {
            $tanggal = date('Y-m-d', strtotime(str_replace('/', '-', $tanggal)));
        } else {
            $tanggal = date('Y-m-d');
        }

        $list = new ListSaldoKasPetugasExport($kode_cabang, $tanggal, $created_by, 'csv');

        return $list->download('LAPORAN_SALDO_KAS_PETUGAS_' . $cabang . '_' . $tanggal . '.csv');
    }

    function rekap_saldo_anggota(Request $request)
    {
        $kode_cabang = $request->kode_cabang;
        $rekap_by = $request->rekap_by;

        if ($kode_cabang <> '~' and $kode_cabang <> '00000' and !empty($kode_cabang) and $kode_cabang <> null) {
            $branch = KopCabang::where('kode_cabang', $kode_cabang)->first();
            $cabang = $branch->nama_cabang;
        } else {
            $cabang = 'SEMUA CABANG';
        }

        $show = KopAnggota::rekap_saldo_anggota($kode_cabang, $rekap_by);

        $data = array();

        $total_anggota = 0;
        $total_simwa = 0;
        $total_simpok = 0;
        $total_simsuk = 0;
        $total_saldo_pokok = 0;
        $total_saldo_margin = 0;
        $total_saldo_catab = 0;

        foreach ($show as $sh) {
            $total_anggota += $sh->jumlah_anggota;
            $total_simwa += $sh->simwa;
            $total_simpok += $sh->simpok;
            $total_simsuk += $sh->simsuk;
            $total_saldo_pokok += $sh->saldo_pokok;
            $total_saldo_margin += $sh->saldo_margin;
            $total_saldo_catab += $sh->saldo_catab;

            $data[] = array(
                'keterangan' => $sh->keterangan,
                'jumlah_anggota' => (int) $sh->jumlah_anggota,
                'simwa' => (int) $sh->simwa,
                'simpok' => (int) $sh->simpok,
                'simsuk' => (int) $sh->simsuk,
                'saldo_pokok' => (int) $sh->saldo_pokok,
                'saldo_margin' => (int) $sh->saldo_margin,
                'saldo_catab' => (int) $sh->saldo_catab
            );
        }

        $res = array(
            'status' => true,
            'nama_cabang' => $cabang,
            'total_anggota' => $total_anggota,
            'total_simwa' => $total_simwa,
            'total_simpok' => $total_simpok,
            'total_simsuk' => $total_simsuk,
            'total_saldo_pokok' => $total_saldo_pokok,
            'total_saldo_margin' => $total_saldo_margin,
            'total_saldo_catab' => $total_saldo_catab,
            'data' => $data
        );

        $response = response()->json($res, 200);

        return $response;
    }

    function rekap_excel_saldo_anggota(Request $request)
    {
        $kode_cabang = $request->kode_cabang;
        $rekap_by = $request->rekap_by;

        if ($kode_cabang <> '~' and $kode_cabang <> '00000' and !empty($kode_cabang) and $kode_cabang <> null) {
            $branch = KopCabang::where('kode_cabang', $kode_cabang)->first();
            $cabang = $branch->nama_cabang;
        } else {
            $cabang = 'SEMUA CABANG';
        }

        $list = new RekapSaldoAnggotaExport($kode_cabang, $rekap_by, 'excel');

        return $list->download('LAPORAN_REKAP_SALDO_ANGGOTA_' . $cabang . '.xlsx');
    }

    function rekap_csv_saldo_anggota(Request $request)
    {
        $kode_cabang = $request->kode_cabang;
        $rekap_by = $request->rekap_by;

        if ($kode_cabang <> '~' and $kode_cabang <> '00000' and !empty($kode_cabang) and $kode_cabang <> null) {
            $branch = KopCabang::where('kode_cabang', $kode_cabang)->first();
            $cabang = $branch->nama_cabang;
        } else {
            $cabang = 'SEMUA CABANG';
        }

        $list = new RekapSaldoAnggotaExport($kode_cabang, $rekap_by, 'csv');

        return $list->download('LAPORAN_REKAP_SALDO_ANGGOTA_' . $cabang . '.csv');
    }

    function rekap_pengajuan(Request $request)
    {
        $kode_cabang = $request->kode_cabang;
        $rekap_by = $request->rekap_by;
        $from_date = $request->from_date;
        $thru_date = $request->thru_date;

        if ($kode_cabang <> '~' and $kode_cabang <> '00000' and !empty($kode_cabang) and $kode_cabang <> null) {
            $branch = KopCabang::where('kode_cabang', $kode_cabang)->first();
            $cabang = $branch->nama_cabang;
        } else {
            $cabang = 'SEMUA CABANG';
        }

        if ($from_date <> '~' and !empty($from_date) and $from_date <> null) {
            $from_date = date('Y-m-d', strtotime(str_replace('/', '-', $from_date)));
        } else {
            $from_date = date('Y-m-d');
        }

        if ($thru_date <> '~' and !empty($thru_date) and $thru_date <> null) {
            $thru_date = date('Y-m-d', strtotime(str_replace('/', '-', $thru_date)));
        } else {
            $thru_date = date('Y-m-d');
        }

        $show = KopPengajuan::rekap_pengajuan($kode_cabang, $rekap_by, $from_date, $thru_date);

        $data = array();

        $sum_anggota = 0;
        $sum_pokok = 0;

        foreach ($show as $sw) {
            $sum_anggota += $sw->jumlah_anggota;
            $sum_pokok += $sw->nominal;
        }

        $total_anggota = 0;
        $total_pokok = 0;

        foreach ($show as $sh) {
            $persen_jumlah = ($sh->jumlah_anggota / $sum_anggota) * 100;
            $persen_nominal = ($sh->nominal / $sum_pokok) * 100;

            $total_anggota += $sh->jumlah_anggota;
            $total_pokok += $sh->nominal;

            $data[] = array(
                'keterangan' => $sh->keterangan,
                'jumlah_anggota' => $sh->jumlah_anggota,
                'nominal' => (int) $sh->nominal,
                'persen_jumlah' => (int) $persen_jumlah,
                'persen_nominal' => (int) $persen_nominal
            );
        }

        $res = array(
            'status' => true,
            'nama_cabang' => $cabang,
            'from_date' => $from_date,
            'thru_date' => $thru_date,
            'total_anggota' => $total_anggota,
            'total_pokok' => $total_pokok,
            'data' => $data
        );

        $response = response()->json($res, 200);

        return $response;
    }

    function rekap_excel_pengajuan(Request $request)
    {
        $kode_cabang = $request->kode_cabang;
        $rekap_by = $request->rekap_by;
        $from_date = $request->from_date;
        $thru_date = $request->thru_date;

        if ($kode_cabang <> '~' and $kode_cabang <> '00000' and !empty($kode_cabang) and $kode_cabang <> null) {
            $branch = KopCabang::where('kode_cabang', $kode_cabang)->first();
            $cabang = $branch->nama_cabang;
        } else {
            $cabang = 'SEMUA CABANG';
        }

        if ($from_date <> '~' and !empty($from_date) and $from_date <> null) {
            $from_date = date('Y-m-d', strtotime(str_replace('/', '-', $from_date)));
        } else {
            $from_date = date('Y-m-d');
        }

        if ($thru_date <> '~' and !empty($thru_date) and $thru_date <> null) {
            $thru_date = date('Y-m-d', strtotime(str_replace('/', '-', $thru_date)));
        } else {
            $thru_date = date('Y-m-d');
        }

        $list = new RekapPengajuanExport($kode_cabang, $rekap_by, $from_date, $thru_date, 'excel');

        return $list->download('LAPORAN_REKAP_PENGAJUAN_' . $cabang . '_' . $from_date . '_' . $thru_date . '.xlsx');
    }

    function rekap_csv_pengajuan(Request $request)
    {
        $kode_cabang = $request->kode_cabang;
        $rekap_by = $request->rekap_by;
        $from_date = $request->from_date;
        $thru_date = $request->thru_date;

        if ($kode_cabang <> '~' and $kode_cabang <> '00000' and !empty($kode_cabang) and $kode_cabang <> null) {
            $branch = KopCabang::where('kode_cabang', $kode_cabang)->first();
            $cabang = $branch->nama_cabang;
        } else {
            $cabang = 'SEMUA CABANG';
        }

        if ($from_date <> '~' and !empty($from_date) and $from_date <> null) {
            $from_date = date('Y-m-d', strtotime(str_replace('/', '-', $from_date)));
        } else {
            $from_date = date('Y-m-d');
        }

        if ($thru_date <> '~' and !empty($thru_date) and $thru_date <> null) {
            $thru_date = date('Y-m-d', strtotime(str_replace('/', '-', $thru_date)));
        } else {
            $thru_date = date('Y-m-d');
        }

        $list = new RekapPengajuanExport($kode_cabang, $rekap_by, $from_date, $thru_date, 'csv');

        return $list->download('LAPORAN_REKAP_PENGAJUAN_' . $cabang . '_' . $from_date . '_' . $thru_date . '.csv');
    }

    function rekap_pencairan(Request $request)
    {
        $kode_cabang = $request->kode_cabang;
        $rekap_by = $request->rekap_by;
        $from_date = $request->from_date;
        $thru_date = $request->thru_date;

        if ($kode_cabang <> '~' and $kode_cabang <> '00000' and !empty($kode_cabang) and $kode_cabang <> null) {
            $branch = KopCabang::where('kode_cabang', $kode_cabang)->first();
            $cabang = $branch->nama_cabang;
        } else {
            $cabang = 'SEMUA CABANG';
        }

        if ($from_date <> '~' and !empty($from_date) and $from_date <> null) {
            $from_date = date('Y-m-d', strtotime(str_replace('/', '-', $from_date)));
        } else {
            $from_date = date('Y-m-d');
        }

        if ($thru_date <> '~' and !empty($thru_date) and $thru_date <> null) {
            $thru_date = date('Y-m-d', strtotime(str_replace('/', '-', $thru_date)));
        } else {
            $thru_date = date('Y-m-d');
        }

        $show = KopPembiayaan::rekap_pencairan($kode_cabang, $rekap_by, $from_date, $thru_date);

        $data = array();

        $sum_anggota = 0;
        $sum_pokok = 0;

        foreach ($show as $sw) {
            $sum_anggota += $sw->jumlah_anggota;
            $sum_pokok += $sw->nominal;
        }

        $total_anggota = 0;
        $total_pokok = 0;

        foreach ($show as $sh) {
            $persen_jumlah = ($sh->jumlah_anggota / $sum_anggota) * 100;
            $persen_nominal = ($sh->nominal / $sum_pokok) * 100;

            $total_anggota += $sh->jumlah_anggota;
            $total_pokok += $sh->nominal;

            $data[] = array(
                'keterangan' => $sh->keterangan,
                'jumlah_anggota' => $sh->jumlah_anggota,
                'nominal' => (int) $sh->nominal,
                'persen_jumlah' => (int) $persen_jumlah,
                'persen_nominal' => (int) $persen_nominal
            );
        }

        $res = array(
            'status' => true,
            'nama_cabang' => $cabang,
            'from_date' => $from_date,
            'thru_date' => $thru_date,
            'total_anggota' => $total_anggota,
            'total_pokok' => $total_pokok,
            'data' => $data
        );

        $response = response()->json($res, 200);

        return $response;
    }

    function rekap_excel_pencairan(Request $request)
    {
        $kode_cabang = $request->kode_cabang;
        $rekap_by = $request->rekap_by;
        $from_date = $request->from_date;
        $thru_date = $request->thru_date;

        if ($kode_cabang <> '~' and $kode_cabang <> '00000' and !empty($kode_cabang) and $kode_cabang <> null) {
            $branch = KopCabang::where('kode_cabang', $kode_cabang)->first();
            $cabang = $branch->nama_cabang;
        } else {
            $cabang = 'SEMUA CABANG';
        }

        if ($from_date <> '~' and !empty($from_date) and $from_date <> null) {
            $from_date = date('Y-m-d', strtotime(str_replace('/', '-', $from_date)));
        } else {
            $from_date = date('Y-m-d');
        }

        if ($thru_date <> '~' and !empty($thru_date) and $thru_date <> null) {
            $thru_date = date('Y-m-d', strtotime(str_replace('/', '-', $thru_date)));
        } else {
            $thru_date = date('Y-m-d');
        }

        $list = new RekapPencairanExport($kode_cabang, $rekap_by, $from_date, $thru_date, 'excel');

        return $list->download('LAPORAN_REKAP_PENCAIRAN_' . $cabang . '_' . $from_date . '_' . $thru_date . '.xlsx');
    }

    function rekap_csv_pencairan(Request $request)
    {
        $kode_cabang = $request->kode_cabang;
        $rekap_by = $request->rekap_by;
        $from_date = $request->from_date;
        $thru_date = $request->thru_date;

        if ($kode_cabang <> '~' and $kode_cabang <> '00000' and !empty($kode_cabang) and $kode_cabang <> null) {
            $branch = KopCabang::where('kode_cabang', $kode_cabang)->first();
            $cabang = $branch->nama_cabang;
        } else {
            $cabang = 'SEMUA CABANG';
        }

        if ($from_date <> '~' and !empty($from_date) and $from_date <> null) {
            $from_date = date('Y-m-d', strtotime(str_replace('/', '-', $from_date)));
        } else {
            $from_date = date('Y-m-d');
        }

        if ($thru_date <> '~' and !empty($thru_date) and $thru_date <> null) {
            $thru_date = date('Y-m-d', strtotime(str_replace('/', '-', $thru_date)));
        } else {
            $thru_date = date('Y-m-d');
        }

        $list = new RekapPencairanExport($kode_cabang, $rekap_by, $from_date, $thru_date, 'csv');

        return $list->download('LAPORAN_REKAP_PENCAIRAN_' . $cabang . '_' . $from_date . '_' . $thru_date . '.csv');
    }

    function rekap_outstanding(Request $request)
    {
        $kode_cabang = $request->kode_cabang;
        $rekap_by = $request->rekap_by;

        if ($kode_cabang <> '~' and $kode_cabang <> '00000' and !empty($kode_cabang) and $kode_cabang <> null) {
            $branch = KopCabang::where('kode_cabang', $kode_cabang)->first();
            $cabang = $branch->nama_cabang;
        } else {
            $cabang = 'SEMUA CABANG';
        }

        $show = KopPembiayaan::rekap_outstanding($kode_cabang, $rekap_by);

        $data = array();

        $sum_anggota = 0;
        $sum_saldo_pokok = 0;

        foreach ($show as $sw) {
            $sum_anggota += $sw->jumlah_anggota;
            $sum_saldo_pokok += $sw->saldo_pokok;
        }

        $total_anggota = 0;
        $total_saldo_pokok = 0;
        $total_saldo_margin = 0;
        $total_saldo_catab = 0;

        foreach ($show as $sh) {
            $persen_jumlah = ($sh->jumlah_anggota / $sum_anggota) * 100;
            $persen_nominal = ($sh->saldo_pokok / $sum_saldo_pokok) * 100;

            $total_anggota += $sh->jumlah_anggota;
            $total_saldo_pokok += $sh->saldo_pokok;
            $total_saldo_margin += $sh->saldo_margin;
            $total_saldo_catab += $sh->saldo_catab;

            $data[] = array(
                'keterangan' => $sh->keterangan,
                'jumlah_anggota' => $sh->jumlah_anggota,
                'saldo_pokok' => (int) $sh->saldo_pokok,
                'saldo_margin' => (int) $sh->saldo_margin,
                'saldo_catab' => (int) $sh->saldo_catab,
                'persen_jumlah' => (int) $persen_jumlah,
                'persen_nominal' => (int) $persen_nominal
            );
        }

        $res = array(
            'status' => true,
            'nama_cabang' => $cabang,
            'total_anggota' => $total_anggota,
            'total_saldo_pokok' => $total_saldo_pokok,
            'total_saldo_margin' => $total_saldo_margin,
            'total_saldo_catab' => $total_saldo_catab,
            'data' => $data
        );

        $response = response()->json($res, 200);

        return $response;
    }

    function rekap_excel_outstanding(Request $request)
    {
        $kode_cabang = $request->kode_cabang;
        $rekap_by = $request->rekap_by;

        if ($kode_cabang <> '~' and $kode_cabang <> '00000' and !empty($kode_cabang) and $kode_cabang <> null) {
            $branch = KopCabang::where('kode_cabang', $kode_cabang)->first();
            $cabang = $branch->nama_cabang;
        } else {
            $cabang = 'SEMUA CABANG';
        }

        $list = new RekapOutstandingExport($kode_cabang, $rekap_by, 'excel');

        return $list->download('LAPORAN_REKAP_OUTSTANDING_' . $cabang . '.xlsx');
    }

    function rekap_csv_outstanding(Request $request)
    {
        $kode_cabang = $request->kode_cabang;
        $rekap_by = $request->rekap_by;

        if ($kode_cabang <> '~' and $kode_cabang <> '00000' and !empty($kode_cabang) and $kode_cabang <> null) {
            $branch = KopCabang::where('kode_cabang', $kode_cabang)->first();
            $cabang = $branch->nama_cabang;
        } else {
            $cabang = 'SEMUA CABANG';
        }

        $list = new RekapOutstandingExport($kode_cabang, $rekap_by, 'csv');

        return $list->download('LAPORAN_REKAP_OUTSTANDING_' . $cabang . '.csv');
    }
}
