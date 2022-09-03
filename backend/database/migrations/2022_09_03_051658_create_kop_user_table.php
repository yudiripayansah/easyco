<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

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
            $table->string('id_user', 32)->nullable(FALSE)->default(DB::raw('uuid()'))->unique();
            $table->string('nama_user', 25)->nullable(FALSE);
            $table->integer('role_user')->nullable(FALSE);
            $table->integer('akses_user')->nullable(FALSE);
            $table->integer('status_user')->default(1)->comment('0 = Tidak Aktif, 1 = Aktif');
            $table->string('kode_cabang', 6)->nullable(FALSE);
            $table->string('kode_pgw', 20)->nullable(FALSE);
            $table->string('photo', 150)->nullable(TRUE);
            $table->string('password')->nullable(FALSE);
            $table->string('created_by', 30)->nullable(FALSE);
            $table->timestamps();
            $table->softDeletes();
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
