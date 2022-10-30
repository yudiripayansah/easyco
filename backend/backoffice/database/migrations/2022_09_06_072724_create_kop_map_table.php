<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateKopMapTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kop_map', function (Blueprint $table) {
            $table->id();
            $table->string('id_map', 32)->default(DB::raw('uuid()'))->unique();
            $table->string('no_pengajuan', 20);
            $table->string('no_map', 50)->comment('cif_no+yyyy+mm+dd+hh+mm+ss');
            $table->string('no_telp', 20)->nullable(TRUE);
            $table->integer('pekerjaan')->nullable(TRUE)->default(0)->comment('0 = Tidak Diketahui, 1 = Ibu Rumah Tangga, 2 = Buruh, 3 = Petani, 4 = Pedagang, 5 = Wiraswasta, 6 = Karyawan Swasta, 7 = PNS');
            $table->string('psg_telp', 20)->nullable(TRUE);
            $table->integer('psg_pekerjaan')->nullable(TRUE)->default(0)->comment('0 = Tidak Diketahui, 1 = Ibu Rumah Tangga, 2 = Buruh, 3 = Petani, 4 = Pedagang, 5 = Wiraswasta, 6 = Karyawan Swasta, 7 = PNS');
            $table->decimal('pend_gaji', 14, 2)->nullable(TRUE)->default(0);
            $table->decimal('pend_usaha', 14, 2)->nullable(TRUE)->default(0);
            $table->decimal('pend_lainya', 14, 2)->nullable(TRUE)->default(0);
            $table->integer('jml_tanggungan')->nullable(TRUE);
            $table->string('ket_tanggungan', 100)->nullable(TRUE);
            $table->decimal('by_dapur', 14, 2)->nullable(TRUE)->default(0);
            $table->decimal('by_gas', 14, 2)->nullable(TRUE)->default(0);
            $table->decimal('by_listrik', 14, 2)->nullable(TRUE)->default(0);
            $table->decimal('by_air', 14, 2)->nullable(TRUE)->default(0);
            $table->decimal('by_pulsa', 14, 2)->nullable(TRUE)->default(0);
            $table->decimal('by_spp_anak', 14, 2)->nullable(TRUE)->default(0);
            $table->decimal('by_jajan_anak', 14, 2)->nullable(TRUE)->default(0);
            $table->decimal('by_transport_anak', 14, 2)->nullable(TRUE)->default(0);
            $table->decimal('by_lainya_anak', 14, 2)->nullable(TRUE)->default(0);
            $table->decimal('by_sewa_rumah', 14, 2)->nullable(TRUE)->default(0);
            $table->decimal('by_kredit', 14, 2)->nullable(TRUE)->default(0);
            $table->decimal('by_arisan', 14, 2)->nullable(TRUE)->default(0);
            $table->decimal('by_jajan', 14, 2)->nullable(TRUE)->default(0);
            $table->decimal('by_hutang_ph3', 14, 2)->nullable(TRUE)->default(0);
            $table->decimal('saving_power', 14, 2)->nullable(TRUE)->default(0);
            $table->decimal('repayment_capacity', 14, 2)->nullable(TRUE)->default(0);
            $table->integer('rumah_jml')->nullable(TRUE);
            $table->decimal('rumah_nom', 14, 2)->nullable(TRUE)->default(0);
            $table->string('rumah_ket', 100)->nullable(TRUE);
            $table->integer('tanah_jml')->nullable(TRUE);
            $table->decimal('tanah_nom', 14, 2)->nullable(TRUE)->default(0);
            $table->string('tanah_ket', 100)->nullable(TRUE);
            $table->integer('mobil_jml')->nullable(TRUE);
            $table->decimal('mobil_nom', 14, 2)->nullable(TRUE)->default(0);
            $table->string('mobil_ket', 100)->nullable(TRUE);
            $table->integer('motor_jml')->nullable(TRUE);
            $table->decimal('motor_nom', 14, 2)->nullable(TRUE)->default(0);
            $table->string('motor_ket', 100)->nullable(TRUE);
            $table->integer('sepeda_jml')->nullable(TRUE);
            $table->decimal('sepeda_nom', 14, 2)->nullable(TRUE)->default(0);
            $table->string('sepeda_ket', 100)->nullable(TRUE);
            $table->integer('kulkas_jml')->nullable(TRUE);
            $table->decimal('kulkas_nom', 14, 2)->nullable(TRUE)->default(0);
            $table->string('kulkas_ket', 100)->nullable(TRUE);
            $table->integer('tv_jml')->nullable(TRUE);
            $table->decimal('tv_nom', 14, 2)->nullable(TRUE)->default(0);
            $table->string('tv_ket', 100)->nullable(TRUE);
            $table->integer('mcuci_jml')->nullable(TRUE);
            $table->decimal('mcuci_nom', 14, 2)->nullable(TRUE)->default(0);
            $table->string('mcuci_ket', 100)->nullable(TRUE);
            $table->integer('hp_jml')->nullable(TRUE);
            $table->decimal('hp_nom', 14, 2)->nullable(TRUE)->default(0);
            $table->string('hp_ket', 100)->nullable(TRUE);
            $table->integer('ternak_jml')->nullable(TRUE);
            $table->decimal('ternak_nom', 14, 2)->nullable(TRUE)->default(0);
            $table->string('ternak_ket', 100)->nullable(TRUE);
            $table->string('aset_desc', 100)->nullable(TRUE);
            $table->integer('lama_usaha')->nullable(TRUE)->default(0);
            $table->string('lokasi_usaha', 50)->nullable(TRUE);
            $table->decimal('modal_awal', 14, 2)->nullable(TRUE)->default(0);
            $table->decimal('omset_usaha', 14, 2)->nullable(TRUE)->default(0);
            $table->decimal('hpp_usaha', 14, 2)->nullable(TRUE)->default(0);
            $table->decimal('persediaan_usaha', 14, 2)->nullable(TRUE)->default(0);
            $table->decimal('piutang_usaha', 14, 2)->nullable(TRUE)->default(0);
            $table->integer('frek_belanja')->nullable(TRUE)->default(0);
            $table->decimal('laba_kotor', 14, 2)->nullable(TRUE)->default(0);
            $table->decimal('by_usaha_transport', 14, 2)->nullable(TRUE)->default(0);
            $table->decimal('by_usaha_kirim', 14, 2)->nullable(TRUE)->default(0);
            $table->decimal('by_usaha_karyawan', 14, 2)->nullable(TRUE)->default(0);
            $table->decimal('by_usaha_perawatan', 14, 2)->nullable(TRUE)->default(0);
            $table->decimal('by_usaha_konsumsi', 14, 2)->nullable(TRUE)->default(0);
            $table->decimal('by_usaha_sewa', 14, 2)->nullable(TRUE)->default(0);
            $table->decimal('by_usaha_total', 14, 2)->nullable(TRUE)->default(0);
            $table->decimal('laba_bersih', 14, 2)->nullable(TRUE)->default(0);
            $table->decimal('aset_usaha_nom', 14, 2)->nullable(TRUE)->default(0);
            $table->string('aset_usaha_desc', 50)->nullable(TRUE);
            $table->string('jenis_usaha', 50)->nullable(TRUE);
            $table->string('jenis_komoditi', 50)->nullable(TRUE);
            $table->string('no_izin_usaha', 50)->nullable(TRUE);
            $table->integer('status_map')->nullable(TRUE)->default(0)->comment('0 = Registrasi, 1 = Aktivasi');
            $table->string('created_by', 30);
            $table->timestamps();
            $table->string('updated_by', 30)->nullable(TRUE);
            $table->softDeletes();
            $table->string('deleted_by', 30)->nullable(TRUE);

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
        Schema::dropIfExists('kop_map');
    }
}
