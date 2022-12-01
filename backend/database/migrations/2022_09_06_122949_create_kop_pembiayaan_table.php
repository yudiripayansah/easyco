<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateKopPembiayaanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kop_pembiayaan', function (Blueprint $table) {
            $table->id();
            $table->string('id_pembiayaan', 32)->unique();
            $table->string('kode_produk', 3);
            $table->integer('kode_akad')->comment('0 = Wadiah, 1 = Mudhorobah, 2 = Musyarokah, 3 = Ijarah, 4 = Murobahah, 5 = Istishna, 6 = Qordh');
            $table->string('kode_petugas', 20)->nullable(TRUE);
            $table->string('no_pengajuan', 20);
            $table->string('no_rekening', 25)->unique();
            $table->decimal('pokok', 14, 2)->nullable(TRUE)->default(0);
            $table->decimal('margin', 14, 2)->nullable(TRUE)->default(0);
            $table->decimal('nisbah_bagihasil', 14, 2)->nullable(TRUE)->default(0);
            $table->integer('periode_jangka_waktu')->nullable(TRUE)->default(1)->comment('0 = Harian, 1 = Mingguan, 2 = Bulanan, 3 = Tempo');
            $table->integer('jangka_waktu');
            $table->decimal('angsuran_pokok', 14, 2)->nullable(TRUE)->default(0);
            $table->decimal('angsuran_margin', 14, 2)->nullable(TRUE)->default(0);
            $table->decimal('angsuran_catab', 14, 2)->nullable(TRUE)->default(0);
            $table->decimal('angsuran_minggon', 14, 2)->nullable(TRUE)->default(0);
            $table->decimal('biaya_administrasi', 14, 2)->nullable(TRUE)->default(0);
            $table->decimal('biaya_asuransi_jiwa', 14, 2)->nullable(TRUE)->default(0);
            $table->decimal('biaya_asuransi_jaminan', 14, 2)->nullable(TRUE)->default(0);
            $table->decimal('biaya_notaris', 14, 2)->nullable(TRUE)->default(0);
            $table->decimal('tabungan_persen', 14, 2)->nullable(TRUE)->default(0);
            $table->decimal('dana_kebajikan', 14, 2)->nullable(TRUE)->default(0);
            $table->date('tanggal_registrasi');
            $table->date('tanggal_akad');
            $table->date('tanggal_mulai_angsur');
            $table->date('tanggal_jtempo');
            $table->integer('counter_angsuran')->nullable(TRUE)->default(0);
            $table->decimal('saldo_pokok', 14, 2)->nullable(TRUE)->default(0);
            $table->decimal('saldo_margin', 14, 2)->nullable(TRUE)->default(0);
            $table->decimal('saldo_catab', 14, 2)->nullable(TRUE)->default(0);
            $table->decimal('saldo_minggon', 14, 2)->nullable(TRUE)->default(0);
            $table->date('jtempo_angsuran_last')->nullable(TRUE);
            $table->date('jtempo_angsuran_next')->nullable(TRUE);
            $table->integer('sumber_dana')->nullable(TRUE)->default(0)->comment('0 = Sendiri, 1 = Kreditur, 2 = Campuran');
            $table->decimal('dana_sendiri', 14, 2)->nullable(TRUE)->default(0);
            $table->decimal('dana_kreditur', 14, 2)->nullable(TRUE)->default(0);
            $table->integer('kode_kreditur')->nullable(TRUE)->comment('Referensi Tabel List Kode');
            $table->integer('ujroh_kreditur')->nullable(TRUE)->default(0);
            $table->decimal('ujroh_kreditur_persen', 3, 2)->nullable(TRUE)->default(0);
            $table->integer('ujroh_kreditur_nominal')->nullable(TRUE)->default(0);
            $table->integer('ujroh_kreditur_carabayar')->nullable(TRUE)->default(0);
            $table->integer('status_pyd_kreditur')->nullable(TRUE)->default(0)->comment('0 = Registrasi, 1 = Aktif, 2 = Tolak, 3 = Pengajuan');
            $table->string('no_batch_upload', 25)->nullable(TRUE);
            $table->integer('status_rekening')->nullable(TRUE)->default(0)->comment('0 = Registrasi, 1 = Aktif, 2 = Lunas, 3 = Verifikasi Anggota Keluar');
            $table->integer('status_kolektibilitas')->nullable(TRUE)->default(0)->comment('1 = Lancar, 2 = Dalam Pengawasan, 3 = Kurang Lancar, 4 = Diragukan, 5 = Macet');
            $table->integer('status_par')->nullable(TRUE)->default(0);
            $table->integer('iswakalah')->nullable(TRUE)->default(0)->comment('0 = Tidak, 1 = Ya');
            $table->integer('proses_wakalah')->nullable(TRUE)->default(0)->comment('0 = Belum Diproses, 1 = Sudah Diproses');
            $table->integer('angsuran_jadwal_khusus')->nullable(TRUE)->default(0)->comment('0 = Tidak, 1 = Ya');
            $table->integer('rescheduling')->nullable(TRUE)->default(0)->comment('0 = Tidak, 1 = Ya');
            $table->integer('peruntukan')->comment('Referensi Tabel List Kode');
            $table->string('norek_tabungan', 20)->nullable(TRUE);
            $table->string('no_rekening_o', 20)->nullable(TRUE);
            $table->string('id_anggota_o', 20)->nullable(TRUE);
            $table->text('droping_doc')->nullable(TRUE);
            $table->integer('status_droping')->nullable(TRUE)->default(0)->comment('0 = Belum, 1 = Sudah');
            $table->string('created_by', 30);
            $table->timestamps();
            $table->string('updated_by', 30)->nullable(TRUE);
            $table->string('verified_by', 30)->nullable(TRUE);
            $table->dateTime('verified_at')->nullable(TRUE);
            $table->string('droping_by', 30)->nullable(TRUE);
            $table->dateTime('droping_at')->nullable(TRUE);
            $table->softDeletes();
            $table->string('deleted_by', 30)->nullable(TRUE);

            $table->foreign('kode_produk')->references('kode_produk')->on('kop_prd_pembiayaan')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreign('no_pengajuan')->references('no_pengajuan')->on('kop_pengajuan')->cascadeOnUpdate()->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kop_pembiayaan');
    }
}
