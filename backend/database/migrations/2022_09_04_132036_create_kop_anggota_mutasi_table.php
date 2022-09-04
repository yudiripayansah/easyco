<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateKopAnggotaMutasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kop_anggota_mutasi', function (Blueprint $table) {
            $table->id();
            $table->string('id_mutasi', 32)->default(DB::raw('uuid()'))->unique();
            $table->string('no_anggota', 20);
            $table->integer('jenis_mutasi')->comment('1 = Anggota Mutasi, 2 = Anggota Keluar');
            $table->integer('alasan_mutasi')->comment('1 = Meninggal, 2 = Karakter, 3 = Pindah Lembaga Lain, 4 = Tidak diijinkan Pasangan, 5 = Simpanan Kurang, 6 = Kondisi Keluarga, 7 = Pindah Alamat, 8 = Tidak Setuju Keputusan Lembaga, 9 = Usia / Jompo, 10 = Sakit, 11 = Kumpulan Bubar, 12 = Tidak Punya Waktu, 13 = Kerja, 14 = Cerai, 15 = Pembiayaan Bermasalah, 16 = Usaha Sudah Berkembang, 17 = Tidak Mau Kumpulan, 18 = Batal Pembiayaan (Anggota baru), 19 = Migrasi Anggota Individu');
            $table->text('keterangan_mutasi');
            $table->string('kode_rembug', 20);
            $table->string('kode_rembug_baru', 20)->nullable(TRUE);
            $table->date('tanggal_mutasi');
            $table->decimal('saldo_pokok', 10, 0)->nullable(TRUE)->default(0);
            $table->decimal('saldo_margin', 10, 0)->nullable(TRUE)->default(0);
            $table->decimal('saldo_catab', 10, 0)->nullable(TRUE)->default(0);
            $table->decimal('saldo_minggon', 10, 0)->nullable(TRUE)->default(0);
            $table->decimal('saldo_sukarela', 10, 0)->nullable(TRUE)->default(0);
            $table->decimal('saldo_tab_berencana', 10, 0)->nullable(TRUE)->default(0);
            $table->decimal('saldo_deposito', 10, 0)->nullable(TRUE)->default(0);
            $table->decimal('saldo_simpok', 10, 0)->nullable(TRUE)->default(0);
            $table->decimal('saldo_simwa', 10, 0)->nullable(TRUE)->default(0);
            $table->decimal('bonus_bagihasil', 10, 0)->nullable(TRUE)->default(0);
            $table->decimal('setoran_tambahan', 10, 0)->nullable(TRUE)->default(0);
            $table->decimal('penarikan_sukarela', 10, 0)->nullable(TRUE)->default(0);
            $table->integer('flag_saldo_margin')->nullable(TRUE)->comment('1 = Ada Margin, 2 = Tidak Ada Margin');
            $table->integer('flag_saldo_catab')->nullable(TRUE)->comment('1 = Ada Catab, 2 = Tidak Ada Catab');
            $table->integer('status_mutasi')->nullable(TRUE)->default(0)->comment('0 = Registrasi, 1 = Verifikasi');
            $table->string('kode_petugas', 20);
            $table->string('created_by', 30);
            $table->timestamps();
            $table->string('verified_by', 30)->nullable(TRUE);
            $table->dateTime('verified_at')->nullable(TRUE);
            $table->softDeletes();

            $table->foreign('no_anggota')->references('no_anggota')->on('kop_anggota')->cascadeOnUpdate()->restrictOnDelete();
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
        Schema::dropIfExists('kop_anggota_mutasi');
    }
}
