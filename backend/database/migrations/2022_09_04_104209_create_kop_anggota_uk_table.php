<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateKopAnggotaUkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kop_anggota_uk', function (Blueprint $table) {
            $table->id();
            $table->string('id_anggota_uk', 32)->default(DB::raw('uuid()'))->unique();
            $table->string('no_anggota', 20);
            $table->string('p_nama', 50)->nullable(TRUE);
            $table->string('p_tmplahir', 30)->nullable(TRUE);
            $table->date('p_tglahir')->nullable(TRUE);
            $table->integer('usia')->nullable(TRUE)->default(0);
            $table->string('p_noktp', 30)->nullable(TRUE);
            $table->string('p_nohp', 30)->nullable(TRUE);
            $table->integer('p_pendidikan')->nullable(TRUE)->default(0)->comment('0 = Tidak Diketahui, 1 = SD / MI, 2 = SMP / MTs, 3 = SMK / SMA / MA, 4 = D1, 5 = D2, 6 = D3, 7 = S1, 8 = S2, 9 = S3');
            $table->integer('p_pekerjaan')->nullable(TRUE)->default(0)->comment('0 = Tidak Diketahui, 1 = Ibu Rumah Tangga, 2 = Buruh, 3 = Petani, 4 = Pedagang, 5 = Wiraswasta, 6 = Karyawan Swasta, 7 = PNS');
            $table->string('p_ketpekerjaan', 50)->nullable(TRUE);
            $table->decimal('p_pendapatan', 14, 2)->nullable(TRUE)->default(0);
            $table->integer('jml_anak')->nullable(TRUE)->default(0);
            $table->integer('jml_tanggungan')->nullable(TRUE)->default(0);
            $table->integer('rumah_status')->nullable(TRUE)->default(0)->comment('0 = Tidak Diketahui, 1 = Rumah Sendiri, 2 = Sewa, 3 = Numpang');
            $table->integer('rumah_ukuran')->nullable(TRUE)->default(0)->comment('0 = Tidak Diketahui, 1 = Kecil, 2 = Besar, 3 = Sedang');
            $table->integer('rumah_atap')->nullable(TRUE)->default(0)->comment('0 = Tidak Diketahui, 1 = Genteng, 2 = Asbes, 3 = Rumbia');
            $table->integer('rumah_dinding')->nullable(TRUE)->default(0)->comment('0 = Tidak Diketahui, 1 = Tembok, 2 = Semi Tembok, 3 = Papan, 4 = Bambu');
            $table->integer('rumah_lantai')->nullable(TRUE)->default(0)->comment('0 = Tidak Diketahui, 1 = Tanah, 2 = Semen, 3 = Keramik');
            $table->integer('rumah_jamban')->nullable(TRUE)->default(0)->comment('0 = Tidak Diketahui, 1 = Sungai, 2 = Jamban Terbuka, 3 = WC');
            $table->integer('rumah_air')->nullable(TRUE)->default(0)->comment('0 = Tidak Diketahui, 1 = Sumur Sendiri, 2 = Sumur Bersama, 3 = Sungai, 4 = PDAM / PAMSIMAS');
            $table->integer('lahan_sawah')->nullable(TRUE)->default(0);
            $table->integer('lahan_kebun')->nullable(TRUE)->default(0);
            $table->integer('lahan_pekarangan')->nullable(TRUE)->default(0);
            $table->integer('ternak_sapi')->nullable(TRUE)->default(0);
            $table->integer('ternak_domba')->nullable(TRUE)->default(0);
            $table->integer('ternak_unggas')->nullable(TRUE)->default(0);
            $table->integer('elc_kulkas')->nullable(TRUE)->default(0)->comment('0 = Tidak Memiliki, 1 = Memiliki');
            $table->integer('elc_tv')->nullable(TRUE)->default(0)->comment('0 = Tidak Memiliki, 1 = Memiliki');
            $table->integer('elc_hp')->nullable(TRUE)->default(0)->comment('0 = Tidak Memiliki, 1 = Memiliki');
            $table->integer('kend_sepeda')->nullable(TRUE)->default(0);
            $table->integer('kend_motor')->nullable(TRUE)->default(0);
            $table->integer('ush_rumahtangga')->nullable(TRUE)->default(0)->comment('0 = Tidak Diketahui, 1 = Perdagangan, 2 = Pertanian, 3 = Industri Pengolahan, 4 = Jasa, 5 = Karyawan, 6 = Perikanan, 99 = Lainnya');
            $table->string('ush_komoditi', 50)->nullable(TRUE);
            $table->string('ush_lokasi', 50)->nullable(TRUE);
            $table->decimal('ush_omset', 14, 2)->nullable(TRUE)->default(0);
            $table->integer('by_beras')->nullable(TRUE)->default(0);
            $table->decimal('by_dapur', 14, 2)->nullable(TRUE)->default(0);
            $table->decimal('by_listrik', 14, 2)->nullable(TRUE)->default(0);
            $table->decimal('by_telpon', 14, 2)->nullable(TRUE)->default(0);
            $table->decimal('by_sekolah', 14, 2)->nullable(TRUE)->default(0);
            $table->decimal('by_lain', 14, 2)->nullable(TRUE)->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('no_anggota')->references('no_anggota')->on('kop_anggota')->cascadeOnUpdate()->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kop_anggota_uk');
    }
}
