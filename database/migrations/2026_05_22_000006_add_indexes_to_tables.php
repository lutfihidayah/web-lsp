<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('asesmen', function (Blueprint $table) {
            $table->index('status');
        });

        Schema::table('pendaftaran', function (Blueprint $table) {
            $table->index('status');
        });

        Schema::table('jadwal', function (Blueprint $table) {
            $table->index('tanggal');
        });
    }

    public function down(): void
    {
        Schema::table('asesmen', function (Blueprint $table) {
            $table->dropIndex(['status']);
        });

        Schema::table('pendaftaran', function (Blueprint $table) {
            $table->dropIndex(['status']);
        });

        Schema::table('jadwal', function (Blueprint $table) {
            $table->dropIndex(['tanggal']);
        });
    }
};
