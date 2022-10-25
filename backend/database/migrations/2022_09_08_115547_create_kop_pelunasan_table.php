<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateKopPelunasanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kop_pelunasan', function (Blueprint $table) {
            $table->id();
            $table->string('id_pelunasan', 32)->unique();
            $table->string('id_trx_rembug', 32);
            $table->string('no_rekening', 25);
            $table->decimal('saldo_pokok', 14, 2)->nullable(TRUE)->default(0);
            $table->decimal('saldo_margin', 14, 2)->nullable(TRUE)->default(0);
            $table->decimal('saldo_catab', 14, 2)->nullable(TRUE)->default(0);
            $table->decimal('saldo_minggon', 14, 2)->nullable(TRUE)->default(0);
            $table->decimal('potongan_margin', 14, 2)->nullable(TRUE)->default(0);
            $table->integer('flag_catab')->nullable(TRUE)->default(0)->comment('0 = Tidak, 1 = Ya');
            $table->integer('status_pelunasan')->nullable(TRUE)->default(0)->comment('0 = Registrasi, 1 = Setuju');
            $table->date('tanggal_pelunasan');
            $table->integer('jenis_pembayaran')->nullable(TRUE)->comment('0 = Kas Petugas, 1 = Pinbuk');
            $table->string('kode_kas_petugas', 20)->nullable(TRUE);
            $table->string('no_rekening_pinbuk', 25)->nullable(TRUE);
            $table->string('created_by', 30);
            $table->timestamps();
            $table->string('updated_by', 30)->nullable(TRUE);
            $table->string('verified_by', 30)->nullable(TRUE);
            $table->dateTime('verified_at')->nullable(TRUE);
            $table->softDeletes();
            $table->string('deleted_by', 30)->nullable(TRUE);

            $table->foreign('id_trx_rembug')->references('id_trx_rembug')->on('kop_trx_rembug')->cascadeOnUpdate()->restrictOnDelete();
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
        Schema::dropIfExists('kop_pelunasan');
    }
}
