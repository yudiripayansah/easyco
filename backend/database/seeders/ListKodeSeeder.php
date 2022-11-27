<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use \App\Models\KopListKode;

class ListKodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $listkode = new KopListKode;

        $data = [
            [
                'kode_value' => '1',
                'nama_kode' => 'pekerjaan',
                'kode_display' => 'Ibu Rumah Tangga',
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'kode_value' => '2',
                'nama_kode' => 'pekerjaan',
                'kode_display' => 'Buruh',
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'kode_value' => '3',
                'nama_kode' => 'pekerjaan',
                'kode_display' => 'Petani',
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'kode_value' => '1',
                'nama_kode' => 'peruntukan',
                'kode_display' => 'Modal Kerja',
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'kode_value' => '2',
                'nama_kode' => 'peruntukan',
                'kode_display' => 'Investasi',
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'kode_value' => '3',
                'nama_kode' => 'peruntukan',
                'kode_display' => 'Pendidikan',
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'kode_value' => '1',
                'nama_kode' => 'kreditur',
                'kode_display' => 'Botani',
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'kode_value' => '2',
                'nama_kode' => 'kreditur',
                'kode_display' => 'Hasanah',
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'kode_value' => '3',
                'nama_kode' => 'kreditur',
                'kode_display' => 'Rif\'atul Ummah',
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'kode_value' => '11',
                'nama_kode' => 'transaksi_anggota',
                'kode_display' => 'Bayar Simpok',
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'kode_value' => '12',
                'nama_kode' => 'transaksi_anggota',
                'kode_display' => 'Bayar Simwa',
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'kode_value' => '13',
                'nama_kode' => 'transaksi_anggota',
                'kode_display' => 'Bayar Simsuk',
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'kode_value' => '14',
                'nama_kode' => 'transaksi_anggota',
                'kode_display' => 'Bayar Modal Penyertaan',
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'kode_value' => '21',
                'nama_kode' => 'transaksi_anggota',
                'kode_display' => 'Setoran Tabungan',
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'kode_value' => '22',
                'nama_kode' => 'transaksi_anggota',
                'kode_display' => 'Penarikan Tabungan',
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'kode_value' => '23',
                'nama_kode' => 'transaksi_anggota',
                'kode_display' => 'Bayar By Admin Tabungan',
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'kode_value' => '24',
                'nama_kode' => 'transaksi_anggota',
                'kode_display' => 'Terima Bahas Tabungan',
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'kode_value' => '31',
                'nama_kode' => 'transaksi_anggota',
                'kode_display' => 'Terima Pencairan Pembiayaan',
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'kode_value' => '32',
                'nama_kode' => 'transaksi_anggota',
                'kode_display' => 'Bayar Angs Pokok',
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'kode_value' => '33',
                'nama_kode' => 'transaksi_anggota',
                'kode_display' => 'Bayar Angs Margin',
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'kode_value' => '34',
                'nama_kode' => 'transaksi_anggota',
                'kode_display' => 'Bayar Angs Catab',
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'kode_value' => '35',
                'nama_kode' => 'transaksi_anggota',
                'kode_display' => 'Bayar By Admin Pembiayaan',
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'kode_value' => '36',
                'nama_kode' => 'transaksi_anggota',
                'kode_display' => 'Bayar By Asuransi Pembiayaan',
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        ];

        $listkode::insert($data);

        $this->command->info('List Kode berhasil diinput');
    }
}
