<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Super Admin
        User::firstOrCreate(
            ['email' => 'superadmin@lsp.com'],
            [
                'name'     => 'Super Admin LSP',
                'password' => Hash::make('password123'),
                'role'     => 'superadmin',
                'status'   => 'aktif',
            ]
        );

        // 2. Admin (Biasa)
        User::firstOrCreate(
            ['email' => 'admin@lsp.com'],
            [
                'name'     => 'Admin LSP',
                'password' => Hash::make('password123'),
                'role'     => 'admin',
                'status'   => 'aktif',
            ]
        );

        // 3. Asesor
        User::firstOrCreate(
            ['email' => 'asesor@lsp.com'],
            [
                'name'     => 'Asesor LSP',
                'password' => Hash::make('password123'),
                'role'     => 'asesor',
                'status'   => 'aktif',
            ]
        );
    }
}