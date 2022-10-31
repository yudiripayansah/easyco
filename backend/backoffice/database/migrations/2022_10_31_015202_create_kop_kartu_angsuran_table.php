<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateKopKartuAngsuranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kop_kartu_angsuran', function (Blueprint $table) {
            $table->id();
            $table->string('id_trx_kartu', 32)->default(DB::raw('uuid()'))->unique();
            $table->string('id_trx_rembug', 32)->nullable(TRUE);
            $table->string('id_trx_gl', 32)->nullable(TRUE);
            $table->string('no_rekening', 25);
            $table->integer('angsuran_ke')->nullable(TRUE);
            $table->date('tgl_angsuran')->nullable(TRUE);
            $table->decimal('angsuran_pokok', 14, 0)->nullable(TRUE)->default(0);
            $table->decimal('angsuran_margin', 14, 0)->nullable(TRUE)->default(0);
            $table->decimal('angsuran_catab', 14, 0)->nullable(TRUE)->default(0);
            $table->decimal('saldo_pokok', 14, 0)->nullable(TRUE)->default(0);
            $table->decimal('saldo_margin', 14, 0)->nullable(TRUE)->default(0);
            $table->decimal('saldo_catab', 14, 0)->nullable(TRUE)->default(0);
            $table->integer('flag_bayar')->nullable(TRUE)->default(0)->comment('0 = Belum Dibayar, 1 = Sudah Dibayar');
            $table->date('tgl_bayar')->nullable(TRUE);
            $table->timestamps();

            $table->foreign('id_trx_rembug')->references('id_trx_rembug')->on('kop_trx_rembug')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreign('id_trx_gl')->references('id_trx_gl')->on('kop_trx_gl')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreign('no_rekening')->references('no_rekening')->on('kop_pembiayaan')->cascadeOnUpdate()->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kop_kartu_angsuran');
    }
}
