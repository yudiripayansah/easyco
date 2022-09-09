<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateKopParTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kop_par', function (Blueprint $table) {
            $table->id();
            $table->string('id_par', 32)->default(DB::raw('uuid()'))->unique();
            $table->string('no_rekening', 25);
            $table->string('kategori_par', 10)->nullable(TRUE);
            $table->date('tanggal_hitung');
            $table->integer('angsuran_terbayar')->nullable(TRUE)->default(0);
            $table->decimal('saldo_pokok', 14, 2)->nullable(TRUE)->default(0);
            $table->decimal('saldo_margin', 14, 2)->nullable(TRUE)->default(0);
            $table->integer('hari_nunggak')->nullable(TRUE)->default(0);
            $table->integer('freq_tunggakan')->nullable(TRUE)->default(0);
            $table->decimal('tunggakan_pokok', 14, 2)->nullable(TRUE)->default(0);
            $table->decimal('tunggakan_margin', 14, 2)->nullable(TRUE)->default(0);
            $table->decimal('cpp', 14, 2)->nullable(TRUE)->default(0);
            $table->decimal('cadangan_piutang', 14, 2)->nullable(TRUE)->default(0);
            $table->string('created_by', 30);
            $table->timestamps();
            $table->string('updated_by', 30)->nullable(TRUE);
            $table->softDeletes();
            $table->string('deleted_by', 30)->nullable(TRUE);

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
        Schema::dropIfExists('kop_par');
    }
}
