<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KopPelunasan;

class PelunasanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pelunasan = new KopPelunasan();
        $pelunasan->id_pelunasan = 'b3b5b2b0b1b2b3b4b5b6b7b8b9b0b1b2';
        $pelunasan->id_trx_rembug = '75150b84ca4b4e9f82855c914ae67923';
        $pelunasan->no_rekening = '1010100010003220010001';
        $pelunasan->status_pelunasan = 1;
        $pelunasan->tanggal_pelunasan = '2022-07-25';
        $pelunasan->jenis_pembayaran = 0;
        $pelunasan->kode_kas_petugas = '101010001.01';
        $pelunasan->created_by = 1;

        $pelunasan->save();

        $this->command->info('Pelunasan berhasil diinput');
    }
}
