<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        date_default_timezone_set('Asia/Jakarta');

        $this->call([
            CabangSeeder::class,
            PegawaiSeeder::class,
            UserSeeder::class,
            KotaKabupatenSeeder::class,
            KecamatanSeeder::class,
            DesaSeeder::class,
            GlSeeder::class,
            KasPetugasSeeder::class,
            RembugSeeder::class,
            AnggotaSeeder::class,
            AnggotaUkSeeder::class,
            AnggotaMutasiSeeder::class,
            KatgoriParSeeder::class,
            LembagaSeeder::class,
            ListKodeSeeder::class,
            PrdDepositoSeeder::class,
            PrdPembiayaanSeeder::class,
            PrdTabunganSeeder::class,
            PengajuanSeeder::class,
            MapSeeder::class,
            PembiayaanSeeder::class,
            ParSeeder::class,
            TabunganSeeder::class,
            TrxRembugSeeder::class
        ]);
    }
}
