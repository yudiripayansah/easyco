<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKopPrdTabunganTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kop_prd_tabungan', function (Blueprint $table) {
            $table->id();
            $table->string('kode_produk', 3)->unique();
            $table->string('kode_gl', 20);
            $table->string('nama_produk', 50);
            $table->string('nama_singkat', 20);
            $table->integer('jenis_akad')->nullable(TRUE)->default(0);
            $table->decimal('saldo_minimal', 10, 0)->nullable(TRUE)->default(0);
            $table->decimal('biaya_adm', 10, 0)->nullable(TRUE)->default(0);
            $table->integer('jenis_tabungan')->nullable(TRUE)->default(0)->comment('0 = Reguler, 1 = Berencana');
            $table->decimal('minimal_setoran', 10, 0)->nullable(TRUE)->default(0);
            $table->integer('periode_setoran')->nullable(TRUE)->default(2)->comment('0 = Harian, 1 = Mingguan, 2 = Bulanan');
            $table->integer('minimal_kontrak')->nullable(TRUE)->default(1);
            $table->decimal('nisbah', 6, 2)->nullable(TRUE)->default(0);
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
        Schema::dropIfExists('kop_prd_tabungan');
    }
}
