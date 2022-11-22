<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKopPegawaiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kop_pegawai', function (Blueprint $table) {
            $table->id();
            $table->string('kode_cabang', 6);
            $table->string('kode_pgw', 20)->unique();
            $table->string('nama_pgw', 50);
            $table->string('jenis_kelamin', 1)->comment('P = Pria, W = Wanita');
            $table->text('alamat_pgw')->nullable(TRUE);
            $table->string('no_ktp', 16);
            $table->string('no_hp', 15);
            $table->string('jabatan', 20);
            $table->date('tgl_gabung')->nullable(TRUE);
            $table->string('created_by', 30);
            $table->timestamps();
            $table->string('updated_by', 30)->nullable(TRUE);
            $table->softDeletes();
            $table->string('deleted_by', 30)->nullable(TRUE);

            $table->foreign('kode_cabang')->references('kode_cabang')->on('kop_cabang')->cascadeOnUpdate()->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kop_pegawai');
    }
}
