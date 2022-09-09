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
            ]
        ];

        $listkode::insert($data);

        $this->command->info('List Kode berhasil diinput');
    }
}
