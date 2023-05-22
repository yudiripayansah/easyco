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
            $table->string('area_cabang', 6)->nullable(TRUE);
            $table->string('kode_cabang', 6)->unique();
            $table->string('nama_cabang', 30);
            $table->string('induk_cabang', 6)->nullable(TRUE);
            $table->integer('jenis_cabang')->nullable(TRUE)->comment('1 = Area, 2 = Cabang, 3 = Unit');
            $table->string('pimpinan_cabang', 50)->nullable(TRUE);
            $table->string('created_by', 30);
            $table->timestamps();
            $table->string('updated_by', 30)->nullable(TRUE);
            $table->softDeletes();
            $table->string('deleted_by', 30)->nullable(TRUE);
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
