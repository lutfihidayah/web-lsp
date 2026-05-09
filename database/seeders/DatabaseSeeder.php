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
            PesertaSeeder::class,
            JadwalSeeder::class,
            HasilSeeder::class,
            InformasiSeeder::class,
        ]);
    }
}