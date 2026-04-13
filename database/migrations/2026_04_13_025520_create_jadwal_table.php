<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('skema_id')->constrained('skema')->onDelete('cascade');
            $table->date('tanggal');
            $table->string('waktu');
            $table->string('lokasi');
            $table->string('asesor');
            $table->integer('kuota')->default(30);
            $table->enum('status', ['Terjadwal', 'Berlangsung', 'Selesai', 'Dibatalkan'])->default('Terjadwal');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal');
    }
};