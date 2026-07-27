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
        Schema::create('seats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('venue_id')->constrained()->onDelete('cascade');
            $table->string('row');                 // 'A', 'B', 'C' ...
            $table->integer('number');             // 1, 2, 3 ...
            $table->string('code')->unique();      // 'A1', 'B5' ...
            $table->string('section')->nullable(); // 'sahne', 'balkon', 'engelli', 'vip'
            $table->boolean('is_active')->default(true); // ⭐ Aktif/Pasif
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seats');
    }
};
