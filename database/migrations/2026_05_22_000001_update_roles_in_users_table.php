<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Perbarui kolom 'role' di tabel users untuk menampung role baru:
     * superadmin, admin, asesor, user
     *
     * Mendukung PostgreSQL dan MySQL.
     */
    public function up(): void
    {
        $driver = DB::getDriverName();

        if ($driver === 'pgsql') {
            // PostgreSQL: Ubah type enum melalui ALTER COLUMN TYPE dengan USING cast
            DB::statement("ALTER TABLE users DROP CONSTRAINT IF EXISTS users_role_check");
            DB::statement("ALTER TABLE users ALTER COLUMN role TYPE VARCHAR(20)");
            DB::statement("ALTER TABLE users ADD CONSTRAINT users_role_check CHECK (role IN ('superadmin', 'admin', 'asesor', 'user'))");
            DB::statement("ALTER TABLE users ALTER COLUMN role SET DEFAULT 'user'");
        } elseif ($driver === 'mysql') {
            // MySQL/MariaDB: MODIFY COLUMN untuk enum
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('superadmin', 'admin', 'asesor', 'user') NOT NULL DEFAULT 'user'");
        }
        // SQLite (testing): tidak perlu ALTER TYPE karena SQLite tidak strict pada type
        // Nilai role baru (superadmin, asesor) akan tetap diterima oleh SQLite secara alami
    }

    public function down(): void
    {
        $driver = DB::getDriverName();

        if ($driver === 'pgsql') {
            // Hapus user dengan role baru sebelum rollback constraint
            DB::statement("UPDATE users SET role = 'user' WHERE role NOT IN ('admin', 'user')");
            DB::statement("ALTER TABLE users DROP CONSTRAINT IF EXISTS users_role_check");
            DB::statement("ALTER TABLE users ADD CONSTRAINT users_role_check CHECK (role IN ('admin', 'user'))");
        } else {
            DB::statement("UPDATE users SET role = 'user' WHERE role NOT IN ('admin', 'user')");
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'user') NOT NULL DEFAULT 'user'");
        }
    }
};

