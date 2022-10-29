<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use \App\Models\KopPengajuan;

class PengajuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pengajuan = new KopPengajuan;

        $data = [
            [
                'id_pengajuan' => bin2hex(random_bytes(16)),
                'no_anggota' => '1010100000001',
                'kode_petugas' => '101010001',
                'no_pengajuan' => '22.10101.0001',
                'tanggal_pengajuan' => '2022-09-01',
                'jumlah_pengajuan' => 1000000,
                'pengajuan_ke' => 1,
                'peruntukan' => 1,
                'keterangan_peruntukan' => 'Untuk modal dagang gorengan',
                'rencana_droping' => '2022-09-08',
                'jangka_waktu' => 50,
                'rencana_periode_jwaktu' => 1,
                'status_pengajuan' => 0,
                'jenis_pembiayaan' => 0,
                'sumber_pengembalian' => 0,
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id_pengajuan' => bin2hex(random_bytes(16)),
                'no_anggota' => '1010100000002',
                'kode_petugas' => '101010001',
                'no_pengajuan' => '22.10101.0002',
                'tanggal_pengajuan' => '2022-08-25',
                'jumlah_pengajuan' => 2000000,
                'pengajuan_ke' => 1,
                'peruntukan' => 2,
                'keterangan_peruntukan' => 'Untuk membeli emas',
                'rencana_droping' => '2022-09-01',
                'jangka_waktu' => 50,
                'rencana_periode_jwaktu' => 1,
                'status_pengajuan' => 1,
                'jenis_pembiayaan' => 0,
                'sumber_pengembalian' => 0,
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id_pengajuan' => bin2hex(random_bytes(16)),
                'no_anggota' => '1010100000003',
                'kode_petugas' => '101010001',
                'no_pengajuan' => '22.10101.0003',
                'tanggal_pengajuan' => '2021-08-02',
                'jumlah_pengajuan' => 3000000,
                'pengajuan_ke' => 1,
                'peruntukan' => 3,
                'keterangan_peruntukan' => 'Untuk masuk sekolah anak',
                'rencana_droping' => '2021-08-09',
                'jangka_waktu' => 50,
                'rencana_periode_jwaktu' => 1,
                'status_pengajuan' => 1,
                'jenis_pembiayaan' => 0,
                'sumber_pengembalian' => 0,
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        ];

        $pengajuan::insert($data);

        $this->command->info('Pengajuan berhasil diinput');
    }
}
