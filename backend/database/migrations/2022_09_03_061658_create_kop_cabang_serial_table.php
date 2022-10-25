<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateKopCabangSerialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kop_cabang_serial', function (Blueprint $table) {
            $table->id();
            $table->string('kode_cabang', 6)->nullable(FALSE);
            $table->integer('no_serial')->nullable(TRUE)->default(0);
            $table->integer('reg_pyd')->nullable(TRUE)->default(0);
            $table->timestamps();
            $table->softDeletes();

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
        Schema::dropIfExists('kop_cabang_serial');
    }
}
