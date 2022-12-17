<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateKopKatgoriParTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kop_katgori_par', function (Blueprint $table) {
            $table->id();
            $table->string('id_katgori_par', 32)->unique()->default(DB::raw('uuid()'));
            $table->integer('jumlah_hari_1');
            $table->integer('jumlah_hari_2');
            $table->string('kategori_par', 10);
            $table->decimal('cpp', 14, 2)->nullable(TRUE)->default(0);
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
        Schema::dropIfExists('kop_katgori_par');
    }
}
