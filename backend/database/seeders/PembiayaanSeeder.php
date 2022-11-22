<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use \App\Models\KopPembiayaan;

class PembiayaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pembiayaan = new KopPembiayaan;

        $data = [
            [
                'kode_produk' => '001',
                'kode_akad' => 4,
                'kode_petugas' => '101010001',
                'no_pengajuan' => '22.10101.0002',
                'no_rekening' => '1010100010002220010001',
                'pokok' => 2000000,
                'margin' => 500000,
                'periode_jangka_waktu' => 1,
                'jangka_waktu' => 50,
                'angsuran_pokok' => 40000,
                'angsuran_margin' => 10000,
                'angsuran_catab' => 5000,
                'biaya_administrasi' => 20000,
                'dana_kebajikan' => 20000,
                'tanggal_registrasi' => '2022-08-25',
                'tanggal_akad' => '2022-09-01',
                'tanggal_mulai_angsur' => '2022-09-08',
                'tanggal_jtempo' => '2023-08-17',
                'counter_angsuran' => 0,
                'saldo_pokok' => 2000000,
                'saldo_margin' => 500000,
                'saldo_catab' => 0,
                'jtempo_angsuran_last' => '2022-09-08',
                'jtempo_angsuran_next' => NULL,
                'sumber_dana' => 0,
                'dana_sendiri' => 0,
                'status_rekening' => 1,
                'peruntukan' => 2,
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'verified_by' => 1,
                'verified_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'kode_produk' => '001',
                'kode_akad' => 4,
                'kode_petugas' => '101010001',
                'no_pengajuan' => '22.10101.0003',
                'no_rekening' => '1010100010003220010001',
                'pokok' => 3000000,
                'margin' => 750000,
                'periode_jangka_waktu' => 1,
                'jangka_waktu' => 50,
                'angsuran_pokok' => 60000,
                'angsuran_margin' => 15000,
                'angsuran_catab' => 7500,
                'biaya_administrasi' => 30000,
                'dana_kebajikan' => 30000,
                'tanggal_registrasi' => '2021-08-02',
                'tanggal_akad' => '2021-08-09',
                'tanggal_mulai_angsur' => '2021-08-16',
                'tanggal_jtempo' => '2022-07-25',
                'counter_angsuran' => 50,
                'saldo_pokok' => 0,
                'saldo_margin' => 0,
                'saldo_catab' => 0,
                'jtempo_angsuran_last' => '2022-07-25',
                'jtempo_angsuran_next' => '2022-08-01',
                'sumber_dana' => 0,
                'dana_sendiri' => 0,
                'status_rekening' => 2,
                'peruntukan' => 3,
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'verified_by' => 1,
                'verified_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        ];

        $pembiayaan::insert($data);

        $this->command->info('Pembiayaan berhasil diinput');
    }
}
