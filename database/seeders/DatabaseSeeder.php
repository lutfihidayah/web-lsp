<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            SkemaSeeder::class,
            PesertaSeeder::class,
            InformasiSeeder::class,
        ]);
    }
}