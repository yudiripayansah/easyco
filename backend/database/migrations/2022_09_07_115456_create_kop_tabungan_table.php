<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateKopTabunganTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kop_tabungan', function (Blueprint $table) {
            $table->id();
            $table->string('id_tabungan', 32)->unique()->default(DB::raw('uuid()'));
            $table->string('kode_produk', 3);
            $table->string('no_anggota', 20);
            $table->string('no_rekening', 25)->unique();
            $table->decimal('saldo', 14, 2)->nullable(TRUE)->default(0);
            $table->integer('flag_taber')->nullable(TRUE)->default(0)->comment('0 = Tidak, 1 = Ya');
            $table->integer('jangka_waktu')->nullable(TRUE)->default(0);
            $table->integer('periode_setoran')->nullable(TRUE)->default(1)->comment('0 = Harian, 1 = Mingguan, 2 = Bulanan');
            $table->decimal('setoran', 14, 2)->nullable(TRUE)->default(0);
            $table->integer('counter_setoran')->nullable(TRUE)->default(0);
            $table->integer('status_rekening')->nullable(TRUE)->default(1)->comment('1 = Aktif, 2 = Blokir, 3 = Verifikasi Anggota Keluar, 4 = Tutup',);
            $table->date('tanggal_buka');
            $table->date('tanggal_tutup')->nullable(TRUE);
            $table->string('created_by', 30);
            $table->timestamps();
            $table->string('updated_by', 30)->nullable(TRUE);
            $table->softDeletes();
            $table->string('deleted_by', 30)->nullable(TRUE);

            $table->foreign('kode_produk')->references('kode_produk')->on('kop_prd_tabungan')->cascadeOnUpdate()->restrictOnDelete();
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
        Schema::dropIfExists('kop_tabungan');
    }
}
