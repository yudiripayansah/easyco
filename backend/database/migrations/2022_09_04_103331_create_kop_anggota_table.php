<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateKopAnggotaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kop_anggota', function (Blueprint $table) {
            $table->id();
            $table->string('id_anggota', 32)->unique()->default(DB::raw('uuid()'));
            $table->string('kode_cabang', 6);
            $table->string('kode_rembug', 20)->nullable(TRUE);
            $table->string('no_anggota', 20)->nullable(TRUE)->unique();
            $table->string('nama_anggota', 50);
            $table->string('jenis_kelamin', 1)->comment('P = Pria, W = Wanita');
            $table->string('ibu_kandung', 50);
            $table->string('tempat_lahir', 30);
            $table->date('tgl_lahir');
            $table->text('alamat')->nullable(TRUE);
            $table->string('desa', 30)->nullable(TRUE);
            $table->string('kecamatan', 30)->nullable(TRUE);
            $table->string('kabupaten', 30)->nullable(TRUE);
            $table->string('kodepos', 6)->nullable(TRUE);
            $table->string('no_ktp', 16);
            $table->string('no_npwp', 30)->nullable(TRUE);
            $table->string('no_telp', 20)->nullable(TRUE);
            $table->integer('pendidikan')->nullable(TRUE)->default(0)->comment('0 = Tidak Diketahui, 1 = SD / MI, 2 = SMP / MTs, 3 = SMK / SMA / MA, 4 = D1, 5 = D2, 6 = D3, 7 = S1, 8 = S2, 9 = S3');
            $table->integer('status_perkawinan')->nullable(TRUE)->default(0)->comment('0 = Tidak Diketahui, 1 = Sudah, 2 = Belum');
            $table->string('nama_pasangan', 50)->nullable(TRUE);
            $table->integer('pekerjaan')->nullable(TRUE)->default(0)->comment('0 = Tidak Diketahui, 1 = Ibu Rumah Tangga, 2 = Buruh, 3 = Petani, 4 = Pedagang, 5 = Wiraswasta, 6 = Karyawan Swasta, 7 = PNS');
            $table->string('ket_pekerjaan', 50)->nullable(TRUE);
            $table->decimal('pendapatan_perbulan', 14, 0)->nullable(TRUE)->default(0);
            $table->decimal('simpok', 14, 0)->nullable(TRUE)->default(0);
            $table->decimal('simwa', 14, 2)->nullable(TRUE)->default(0);
            $table->decimal('simsuk', 14, 2)->nullable(TRUE)->default(0);
            $table->date('tgl_gabung');
            $table->integer('status')->nullable(TRUE)->default(1)->comment('0 = Registrasi, 1 = Aktif, 2 = Tidak Aktif, 3 = Menunggu Verifikasi Keluar');
            $table->date('tanggal_keluar')->nullable(TRUE);
            $table->string('created_by', 30);
            $table->timestamps();
            $table->string('updated_by', 30)->nullable(TRUE);
            $table->softDeletes();
            $table->string('deleted_by', 30)->nullable(TRUE);

            $table->foreign('kode_cabang')->references('kode_cabang')->on('kop_cabang')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreign('kode_rembug')->references('kode_rembug')->on('kop_rembug')->cascadeOnUpdate()->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kop_anggota');
    }
}
