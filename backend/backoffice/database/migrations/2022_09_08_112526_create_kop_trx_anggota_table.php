<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateKopTrxAnggotaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kop_trx_anggota', function (Blueprint $table) {
            $table->id();
            $table->string('id_trx_anggota', 32)->default(DB::raw('uuid()'))->unique();
            $table->string('id_trx_rembug', 32)->nullable(TRUE);
            $table->string('no_anggota', 20);
            $table->date('trx_date');
            $table->decimal('amount', 14, 2)->nullable(TRUE)->default(0);
            $table->char('flag_debet_credit', 1);
            $table->integer('trx_type')->comment('1=..., 2=..., 3=..., 4=...');
            $table->text('description')->nullable(TRUE);
            $table->string('created_by', 30);
            $table->timestamps();
            $table->string('updated_by', 30)->nullable(TRUE);
            $table->string('verified_by', 30)->nullable(TRUE);
            $table->dateTime('verified_at')->nullable(TRUE);
            $table->softDeletes();
            $table->string('deleted_by', 30)->nullable(TRUE);

            $table->foreign('no_anggota')->references('no_anggota')->on('kop_anggota')->cascadeOnUpdate()->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kop_trx_anggota');
    }
}
