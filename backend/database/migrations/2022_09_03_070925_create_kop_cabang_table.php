<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKopCabangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kop_cabang', function (Blueprint $table) {
            $table->id();
            $table->string('kode_cabang', 6)->nullable(FALSE);
            $table->string('nama_cabang', 30)->nullable(FALSE);
            $table->string('induk_cabang', 6)->nullable(TRUE);
            $table->integer('jenis_cabang')->nullable(TRUE);
            $table->string('pimpinan_cabang', 50)->nullable(TRUE);
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
        Schema::dropIfExists('kop_cabang');
    }
}
