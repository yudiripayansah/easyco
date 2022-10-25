<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateKopTrxGlDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kop_trx_gl_detail', function (Blueprint $table) {
            $table->id();
            $table->string('id_trx_gl_detail', 32)->unique();
            $table->string('id_trx_gl', 32);
            $table->string('kode_gl', 20);
            $table->char('flag_dc', 1);
            $table->decimal('amount', 14, 2)->nullable(TRUE)->default(0);
            $table->text('description')->nullable(TRUE);
            $table->integer('trx_sequence')->nullable(TRUE)->default(0);

            $table->foreign('id_trx_gl')->references('id_trx_gl')->on('kop_trx_gl')->cascadeOnUpdate()->restrictOnDelete();
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
        Schema::dropIfExists('kop_trx_gl_detail');
    }
}
