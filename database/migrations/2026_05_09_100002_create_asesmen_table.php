<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asesmen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftaran_id')->constrained('pendaftaran')->onDelete('cascade');
            $table->enum('status', ['berlangsung', 'selesai', 'lulus', 'tidak_lulus'])->default('berlangsung');
            $table->integer('nilai_quiz')->nullable();
            $table->string('no_sertifikat')->nullable();
            $table->timestamp('sertifikat_dibuat_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asesmen');
    }
};
