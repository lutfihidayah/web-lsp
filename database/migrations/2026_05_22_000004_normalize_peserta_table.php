<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\User;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tambahkan kolom user_id yang nullable terlebih dahulu
        Schema::table('peserta', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('id')->constrained('users')->onDelete('cascade');
        });

        // 2. Migrasikan data peserta yang ada ke tabel users jika belum ada
        $pesertas = DB::table('peserta')->get();
        foreach ($pesertas as $peserta) {
            $user = DB::table('users')->where('email', $peserta->email)->first();

            if (!$user) {
                // Buat user baru untuk peserta yang tidak punya user
                $userId = DB::table('users')->insertGetId([
                    'name' => $peserta->nama,
                    'email' => $peserta->email,
                    'password' => bcrypt('password'), // password default
                    'role' => 'user',
                    'status' => 'aktif',
                    'no_telepon' => $peserta->no_telepon ?? '-',
                    'created_at' => $peserta->created_at ?? now(),
                    'updated_at' => $peserta->updated_at ?? now(),
                ]);
            } else {
                $userId = $user->id;
                // Jika no_telepon di user kosong, update dari peserta
                if (empty($user->no_telepon) && !empty($peserta->no_telepon)) {
                    DB::table('users')->where('id', $user->id)->update([
                        'no_telepon' => $peserta->no_telepon
                    ]);
                }
            }

            // Hubungkan peserta dengan user_id
            DB::table('peserta')->where('id', $peserta->id)->update([
                'user_id' => $userId
            ]);
        }

        // 3. Ubah user_id menjadi NOT NULL (di beberapa driver mungkin harus dengan raw statement)
        $driver = DB::getDriverName();
        if ($driver === 'mysql') {
            DB::statement("ALTER TABLE peserta MODIFY COLUMN user_id BIGINT UNSIGNED NOT NULL");
        } elseif ($driver === 'pgsql') {
            DB::statement("ALTER TABLE peserta ALTER COLUMN user_id SET NOT NULL");
        }

        // 4. Drop unique index dan kolom duplikat dari tabel peserta
        Schema::table('peserta', function (Blueprint $table) {
            $table->dropUnique(['email']);
        });

        Schema::table('peserta', function (Blueprint $table) {
            $table->dropColumn(['nama', 'email', 'no_telepon']);
        });
    }

    public function down(): void
    {
        // 1. Tambahkan kembali kolom yang didrop
        Schema::table('peserta', function (Blueprint $table) {
            $table->string('nama')->nullable()->after('user_id');
            $table->string('email')->nullable()->after('nama');
            $table->string('no_telepon')->nullable()->after('email');
        });

        // 2. Kembalikan data dari tabel users ke tabel peserta
        $pesertas = DB::table('peserta')->get();
        foreach ($pesertas as $peserta) {
            if ($peserta->user_id) {
                $user = DB::table('users')->where('id', $peserta->user_id)->first();
                if ($user) {
                    DB::table('peserta')->where('id', $peserta->id)->update([
                        'nama' => $user->name,
                        'email' => $user->email,
                        'no_telepon' => $user->no_telepon,
                    ]);
                }
            }
        }

        // 3. Tambahkan kembali unique constraint pada email
        Schema::table('peserta', function (Blueprint $table) {
            $table->unique('email');
        });

        // 4. Drop foreign key dan kolom user_id
        Schema::table('peserta', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
