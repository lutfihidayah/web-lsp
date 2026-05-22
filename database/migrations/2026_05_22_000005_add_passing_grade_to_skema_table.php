<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('skema', function (Blueprint $table) {
            $table->integer('passing_grade')->default(60)->after('harga');
        });
    }

    public function down(): void
    {
        Schema::table('skema', function (Blueprint $table) {
            $table->dropColumn('passing_grade');
        });
    }
};
