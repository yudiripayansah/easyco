<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateKopTrxKasPetugasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kop_trx_kas_petugas', function (Blueprint $table) {
            $table->id();
            $table->string('id_trx_kas_petugas', 32)->unique()->default(DB::raw('uuid()'));
            $table->string('kode_kas_petugas', 20);
            $table->string('id_trx_rembug', 32)->nullable(TRUE);
            $table->integer('jenis_trx')->nullable(TRUE)->comment('1 = Droping Kas, 2 = Setoran Rembug, 3 = Penarikan Rembug, 4 = Setor ke Teller, 5 = Setoran Individu, 6 = Penarikan Individu');
            $table->char('debit_credit', 1);
            $table->decimal('jumlah_trx', 14, 2)->nullable(TRUE)->default(0);
            $table->date('trx_date');
            $table->date('voucher_date');
            $table->string('voucher_ref', 25)->nullable(TRUE);
            $table->text('keterangan')->nullable(TRUE);
            $table->integer('status_trx')->nullable(TRUE)->default(0)->comment('0 = Baru Registrasi, 1 = Sudah Verifikasi');
            $table->string('created_by', 30);
            $table->timestamps();
            $table->string('updated_by', 30)->nullable(TRUE);
            $table->string('verified_by', 30)->nullable(TRUE);
            $table->dateTime('verified_at')->nullable(TRUE);
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
        Schema::dropIfExists('kop_trx_kas_petugas');
    }
}
