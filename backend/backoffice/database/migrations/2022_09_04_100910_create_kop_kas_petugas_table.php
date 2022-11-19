<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateKopKasPetugasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kop_kas_petugas', function (Blueprint $table) {
            $table->id();
            $table->string('id_kas_petugas', 32)->unique();
            $table->string('id_user', 32);
            $table->string('kode_kas_petugas', 20)->unique();
            $table->string('kode_petugas', 20)->unique();
            $table->string('kode_gl', 20);
            $table->string('nama_kas_petugas', 100);
            $table->decimal('saldo', 14, 2)->nullable(TRUE)->default(0);
            $table->integer('jenis_kas_petugas')->comment('0 = Kas Petugas, 1 = Kas Teller');
            $table->integer('status_kas_petugas')->nullable(TRUE)->default(1)->comment('0 = Tidak Aktif, 1 = Aktif');
            $table->string('created_by', 30);
            $table->timestamps();
            $table->string('updated_by', 30)->nullable(TRUE);
            $table->softDeletes();
            $table->string('deleted_by', 30)->nullable(TRUE);

            $table->foreign('id_user')->references('id_user')->on('kop_user')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreign('kode_gl')->references('kode_gl')->on('kop_gl')->cascadeOnUpdate()->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kop_kas_petugas');
    }
}
