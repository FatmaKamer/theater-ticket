<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void //php artisan migrate dediğimde bu fonksiyon çalışır ve users tablosuna role sütununu ekler.
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['user', 'admin'])->default('user')->after('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void ////php artisan migrate:rollback dendiğinde sütunu siler.
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};
