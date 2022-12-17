<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use \App\Models\KopUser;
use Illuminate\Support\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new KopUser;

        $data = [
            [
                'id_user' => '08c3ead1abc849149478a0011791ea84',
                'kode_cabang' => '10101',
                'kode_pgw' => '101010001',
                'nama_user' => 'ummar',
                'role_user' => '1',
                'akses_user' => '1',
                'status_user' => '1',
                'password' => Hash::make('easycoOk'),
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id_user' => '76987fd7b81a15d385cc91f37f940fd8',
                'kode_cabang' => '10102',
                'kode_pgw' => '101020002',
                'nama_user' => 'danu',
                'role_user' => '1',
                'akses_user' => '1',
                'status_user' => '1',
                'password' => Hash::make('danu'),
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id_user' => 'b59a3a872ed02978122e921f649665eb',
                'kode_cabang' => '10102',
                'kode_pgw' => '101020001',
                'nama_user' => 'rizki',
                'role_user' => '1',
                'akses_user' => '1',
                'status_user' => '1',
                'password' => Hash::make('rizki'),
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id_user' => 'a3dd38121e0ac26bece0331ada658edd',
                'kode_cabang' => '10101',
                'kode_pgw' => '101010002',
                'nama_user' => 'adminmsi',
                'role_user' => '1',
                'akses_user' => '1',
                'status_user' => '1',
                'password' => Hash::make('adminmsi'),
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id_user' => '98864ec6829242b1354ec3ef549de1fe',
                'kode_cabang' => '00000',
                'kode_pgw' => NULL,
                'nama_user' => 'sysadmin',
                'role_user' => '1',
                'akses_user' => '1',
                'status_user' => '1',
                'password' => Hash::make('msisyariah'),
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id_user' => '92715fa82353c854b2af6e0070f165a6',
                'kode_cabang' => '10101',
                'kode_pgw' => '101010003',
                'nama_user' => 'amin',
                'role_user' => '1',
                'akses_user' => '1',
                'status_user' => '1',
                'password' => Hash::make('amin'),
                'created_by' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')

            ]
        ];

        $user::insert($data);

        $this->command->info('User berhasil diinput');
    }
}
