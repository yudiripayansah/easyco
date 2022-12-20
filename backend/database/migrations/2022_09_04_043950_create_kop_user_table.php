<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateKopUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kop_user', function (Blueprint $table) {
            $table->id();
            $table->string('id_user', 32)->unique()->default(DB::raw('uuid()'));
            $table->string('kode_cabang', 6);
            $table->string('kode_pgw', 20)->nullable(TRUE);
            $table->string('nama_user', 25)->unique();
            $table->integer('role_user');
            $table->integer('akses_user');
            $table->integer('status_user')->nullable(TRUE)->default(1)->comment('0 = Tidak Aktif, 1 = Aktif');
            $table->string('photo', 150)->nullable(TRUE);
            $table->string('password');
            $table->dateTime('last_login')->nullable(TRUE);
            $table->text('token')->nullable(TRUE);
            $table->string('created_by', 30);
            $table->timestamps();
            $table->string('updated_by', 30)->nullable(TRUE);
            $table->softDeletes();
            $table->string('deleted_by', 30)->nullable(TRUE);

            $table->foreign('kode_cabang')->references('kode_cabang')->on('kop_cabang')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreign('kode_pgw')->references('kode_pgw')->on('kop_pegawai')->cascadeOnUpdate()->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kop_user');
    }
}
