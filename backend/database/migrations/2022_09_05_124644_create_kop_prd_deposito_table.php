<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKopPrdDepositoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kop_prd_deposito', function (Blueprint $table) {
            $table->id();
            $table->string('kode_produk', 3)->unique();
            $table->string('kode_gl', 20);
            $table->string('nama_produk', 50);
            $table->string('nama_singkat', 20);
            $table->integer('periode_setoran')->nullable(TRUE)->default(0)->comment('0 = Tahunan, 1 = Bulanan');
            $table->integer('jangka_waktu');
            $table->decimal('minimal_setoran', 12, 0)->nullable(TRUE)->default(0);
            $table->decimal('nisbah', 6, 2)->nullable(TRUE)->default(0);
            $table->decimal('persen_pajak', 10, 2)->nullable(TRUE)->default(0);
            $table->string('created_by', 30);
            $table->timestamps();
            $table->string('updated_by', 30)->nullable(TRUE);
            $table->softDeletes();
            $table->string('deleted_by', 30)->nullable(TRUE);

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
        Schema::dropIfExists('kop_prd_deposito');
    }
}
