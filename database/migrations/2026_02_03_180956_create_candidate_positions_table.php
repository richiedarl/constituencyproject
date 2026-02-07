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
        Schema::create('candidate_positions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('candidate_id')
              ->constrained()
              ->cascadeOnDelete();

            $table->string('position'); // e.g. Councillor, Senator
            $table->year('year_from');
            $table->year('year_until')->nullable(); // null if current

            $table->boolean('is_current')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidate_positions');
    }
};
