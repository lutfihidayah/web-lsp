<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            SkemaSeeder::class,
            SoalSeeder::class,
            PesertaSeeder::class,
            JadwalSeeder::class,
            HasilSeeder::class,
            InformasiSeeder::class,
            //PendaftaranSeeder::class,
        ]);
    }
}