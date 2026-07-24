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
        Schema::create('plays', function (Blueprint $table) {
            $table->id();

            $table->string('name');

            $table->text('description')->nullable();

            $table->integer('duration')->nullable();

            $table->string('author')->nullable();

            $table->string('director')->nullable();

            $table->text('cast')->nullable();

            $table->string('image')->nullable();

            $table->foreignId('venue_id')
                ->constrained('venues')
                ->onDelete('cascade');

            $table->boolean('is_active')->default(false);

            $table->decimal('ticket_price', 10, 2)->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plays');
    }
};
