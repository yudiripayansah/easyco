<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKopLembagaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kop_lembaga', function (Blueprint $table) {
            $table->id();
            $table->string('kode_kop', 20)->unique();
            $table->string('nama_kop', 100);
            $table->text('alamat_kop');
            $table->string('nik_kop', 100);
            $table->decimal('simpok', 14, 0)->nullable(TRUE)->default(0);
            $table->decimal('simwa', 14, 0)->nullable(TRUE)->default(0);
            $table->string('gl_simpok', 20);
            $table->string('gl_simwa', 20);
            $table->string('gl_simsuk', 20);
            $table->text('tagline_kop')->nullable(TRUE);
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
        Schema::dropIfExists('kop_lembaga');
    }
}
