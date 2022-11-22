<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateKopTrxRembugTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kop_trx_rembug', function (Blueprint $table) {
            $table->id();
            $table->string('id_trx_rembug', 32)->unique();
            $table->string('kode_rembug', 20);
            $table->string('kode_petugas', 20);
            $table->date('trx_date');
            $table->string('created_by', 30);
            $table->timestamps();
            $table->string('updated_by', 30)->nullable(TRUE);
            $table->string('verified_by', 30)->nullable(TRUE);
            $table->dateTime('verified_at')->nullable(TRUE);
            $table->softDeletes();
            $table->string('deleted_by', 30)->nullable(TRUE);

            $table->foreign('kode_rembug')->references('kode_rembug')->on('kop_rembug')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreign('kode_petugas')->references('kode_petugas')->on('kop_kas_petugas')->cascadeOnUpdate()->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kop_trx_rembug');
    }
}
