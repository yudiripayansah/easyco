<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateKopTrxGlTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kop_trx_gl', function (Blueprint $table) {
            $table->id();
            $table->string('id_trx_gl', 32)->unique()->default(DB::raw('uuid()'));
            $table->string('kode_cabang', 6);
            $table->date('trx_date');
            $table->date('voucher_date');
            $table->string('voucher_no', 32)->nullable(TRUE);
            $table->text('description')->nullable(TRUE);
            $table->integer('trx_type')->comment('0 = Jurnal Umum, 1 = Transaksi Anggota, 2 = Transaksi Kas Petugas, 3 = Transaksi Rembug');
            $table->string('jurnal_id', 32)->nullable(TRUE);
            $table->string('created_by', 30);
            $table->timestamps();
            $table->string('updated_by', 30)->nullable(TRUE);
            $table->string('verified_by', 30)->nullable(TRUE);
            $table->dateTime('verified_at')->nullable(TRUE);
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
        Schema::dropIfExists('kop_trx_gl');
    }
}
