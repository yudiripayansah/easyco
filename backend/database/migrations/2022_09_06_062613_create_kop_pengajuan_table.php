<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateKopPengajuanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kop_pengajuan', function (Blueprint $table) {
            $table->id();
            $table->string('id_pengajuan', 32)->default(DB::raw('uuid()'))->unique();
            $table->string('no_anggota', 20);
            $table->string('kode_petugas', 20);
            $table->string('no_pengajuan', 20)->nullable(TRUE)->unique()->comment('yy.branc_code.xxxx');
            $table->date('tanggal_pengajuan');
            $table->decimal('jumlah_pengajuan', 14, 2)->nullable(TRUE)->default(0);
            $table->integer('pengajuan_ke');
            $table->integer('peruntukan')->comment('Referensi Tabel List Kode');
            $table->string('keterangan_peruntukan', 100);
            $table->date('rencana_droping');
            $table->integer('rencana_periode_jwaktu')->nullable(TRUE)->default(1)->comment('0 = Harian, 1 = Mingguan, 2 = Bulanan, 3 = Tempo');
            $table->integer('status_pengajuan')->nullable(TRUE)->default(0)->comment('0 = Registrasi, 1 = Aktivasi, 2 = Tolak, 3 = Batal');
            $table->integer('jenis_pembiayaan')->nullable(TRUE)->default(0)->comment('0 = Kelompok, 1 = Individu');
            $table->integer('sumber_pengembalian')->nullable(TRUE)->default(0)->comment('0 = Sumber Usaha, 1 = Non Usaha');
            $table->text('doc_ktp')->nullable(TRUE);
            $table->text('doc_kk')->nullable(TRUE);
            $table->text('doc_pendukung')->nullable(TRUE);
            $table->text('ttd_anggota')->nullable(TRUE);
            $table->text('ttd_suami')->nullable(TRUE);
            $table->text('ttd_ketua_majelis')->nullable(TRUE);
            $table->text('ttd_tpl')->nullable(TRUE);
            $table->string('no_pengajuan_o', 20)->nullable(TRUE);
            $table->string('no_anggota_o', 20)->nullable(TRUE);
            $table->string('created_by', 30);
            $table->timestamps();
            $table->string('updated_by', 30)->nullable(TRUE);
            $table->softDeletes();
            $table->string('deleted_by', 30)->nullable(TRUE);

            $table->foreign('no_anggota')->references('no_anggota')->on('kop_anggota')->cascadeOnUpdate()->restrictOnDelete();
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
        Schema::dropIfExists('kop_pengajuan');
    }
}
