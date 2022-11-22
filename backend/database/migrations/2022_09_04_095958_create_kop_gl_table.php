<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKopGlTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kop_gl', function (Blueprint $table) {
            $table->id();
            $table->string('kode_gl', 20)->unique();
            $table->string('group_gl', 20);
            $table->integer('tipe_gl')->comment('1 = Aset, 2 = Utang, 3 = Modal, 4 = Pendapatan, 5 = Biaya / Beban');
            $table->string('default_saldo', 1)->comment('D = Debet, C = Credit');
            $table->string('flag_akses', 1)->nullable(TRUE)->default('S')->comment('S = Semua, P = Pusat, C = Cabang');
            $table->string('nama_gl', 100);
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
        Schema::dropIfExists('kop_gl');
    }
}
