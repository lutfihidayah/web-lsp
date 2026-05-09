<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pendaftaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('skema_id')->constrained('skema')->onDelete('cascade');
            $table->foreignId('jadwal_id')->nullable()->constrained('jadwal')->onDelete('set null');
            $table->string('order_id')->unique();
            $table->string('snap_token')->nullable();
            $table->bigInteger('amount');
            $table->enum('status', ['pending', 'paid', 'failed', 'expired'])->default('pending');
            $table->string('payment_type')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->json('midtrans_response')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pendaftaran');
    }
};
