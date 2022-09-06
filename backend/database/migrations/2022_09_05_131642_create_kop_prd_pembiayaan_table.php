<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKopPrdPembiayaanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kop_prd_pembiayaan', function (Blueprint $table) {
            $table->id();
            $table->string('kode_produk', 3)->unique();
            $table->integer('kode_akad')->comment('0 = Wadiah, 1 = Mudhorobah, 2 = Musyarokah, 3 = Ijarah, 4 = Murobahah, 5 = Istishna, 6 = Qordh');
            $table->string('kode_gl', 20);
            $table->string('nama_produk', 50);
            $table->string('nama_singkat', 20);
            $table->integer('periode_angsuran')->comment('0 = Harian, 1 = Mingguan, 2 = Bulanan, 3 = Jatuh Tempo, 4 = Skema Khusus');
            $table->integer('jangka_waktu');
            $table->decimal('biaya_adm', 14, 2)->nullable(TRUE)->default(0);
            $table->integer('flag_wakalah')->nullable(TRUE)->comment('Khusus Akad Murobahah, 0 = Tanpa Wakalah (Persediaan), 1 = Dengan Wakalah');
            $table->integer('flag_pdd')->nullable(TRUE);
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
        Schema::dropIfExists('kop_prd_pembiayaan');
    }
}
