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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->integer('candidate_id')->nullable();
            /*
            |--------------------------------------------------------------------------
            | Core
            |--------------------------------------------------------------------------
            */
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->text('short_description')->nullable();
            $table->string('type')->nullable(); // e.g. road, school, hospital
            $table->string('status')->default('planning'); // planning | ongoing | completed | stalled

            /*
            |--------------------------------------------------------------------------
            | Location
            |--------------------------------------------------------------------------
            */
            $table->string('state')->nullable();
            $table->string('lga')->nullable();
            $table->string('ward')->nullable();
            $table->string('community')->nullable();
            $table->string('address')->nullable();

            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();

            /*
            |--------------------------------------------------------------------------
            | Timeline & Cost
            |--------------------------------------------------------------------------
            */
            $table->date('start_date')->nullable();
            $table->date('completion_date')->nullable();

            $table->decimal('estimated_budget', 15, 2)->nullable();
            $table->decimal('actual_cost', 15, 2)->nullable();
            $table->bigInteger('contractor_count')->default(0);

            /*
            |--------------------------------------------------------------------------
            | Media
            |--------------------------------------------------------------------------
            */
            $table->string('featured_image')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Visibility
            |--------------------------------------------------------------------------
            */
            $table->boolean('is_public')->default(true);
            $table->boolean('is_active')->default(true);

            /*
            |--------------------------------------------------------------------------
            | Audit
            |--------------------------------------------------------------------------
            */
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
