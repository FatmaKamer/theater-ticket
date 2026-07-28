<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('seats', function (Blueprint $table) {
            // 1. Önce eski unique constraint'i kaldır
            $table->dropUnique('seats_code_unique');

            // 2. Yeni unique constraint (venue_id + code birlikte)
            $table->unique(['venue_id', 'code']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('seats', function (Blueprint $table) {
            // 1. Yeni unique'i kaldır
            $table->dropUnique(['venue_id', 'code']);

            // 2. Eski unique'i geri ekle
            $table->unique('code');
        });
    }
};
