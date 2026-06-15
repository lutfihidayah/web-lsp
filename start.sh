#!/bin/bash

# Ini adalah script yang akan dijalankan oleh Render saat web pertama kali dihidupkan

# 1. Jalankan migrasi database otomatis (ini akan membuat tabel-tabel di database Render)
php artisan migrate --force

# 2. Opsional: Jalankan seeder jika ada data awal (Hapus tanda pagar di bawah jika ingin menggunakannya)
# php artisan db:seed --force

# 3. Hapus cache config agar selalu update
php artisan config:clear

# 4. Mulai server web Apache agar web bisa diakses
apache2-foreground
