<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateKopRembugTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kop_rembug', function (Blueprint $table) {
            $table->id();
            $table->string('id_rembug', 32)->unique()->default(DB::raw('uuid()'));
            $table->string('kode_rembug', 20)->unique();
            $table->string('kode_cabang', 6);
            $table->string('kode_desa', 10);
            $table->string('kode_petugas', 20);
            $table->string('nama_rembug', 50);
            $table->date('tgl_pembentukan');
            $table->integer('hari_transaksi')->comment('0 = Minggu, 1 = Senin, 2 = Selasa, 3 = Rabu, 4 = Kamis, 5 = Jumat, 6 = Sabtu');
            $table->string('jam_transaksi', 5);
            $table->integer('status_aktif')->nullable(TRUE)->default(1)->comment('0 = Tidak Aktif, 1 = Aktif');
            $table->string('created_by', 30);
            $table->timestamps();
            $table->string('updated_by', 30)->nullable(TRUE);
            $table->softDeletes();
            $table->string('deleted_by', 30)->nullable(TRUE);

            $table->foreign('kode_cabang')->references('kode_cabang')->on('kop_cabang')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreign('kode_desa')->references('kode_desa')->on('kop_desa')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreign('kode_petugas')->references('kode_petugas')->on('kop_kas_petugas')->cascadeOnUpdate()->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kop_rembug');
    }
}
