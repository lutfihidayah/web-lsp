<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('absensi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asesmen_id')->constrained('asesmen')->onDelete('cascade');
            $table->integer('pertemuan_ke');
            $table->date('tanggal')->nullable();
            $table->enum('status', ['hadir', 'tidak_hadir', 'belum'])->default('belum');
            $table->string('dikonfirmasi_oleh')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('absensi');
    }
};
