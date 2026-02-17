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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();

            $table->foreignId('project_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('contractor_id');

            $table->foreignId('contributor_id');
            // $table->foreignId('project_id');

            $table->foreignId('candidate_id');

            $table->text('cover_letter')->nullable();

            $table->string('status')
                ->default('pending'); // pending, approved, rejected

            $table->timestamps();

            $table->unique(['project_id', 'contractor_id']);
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
