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
        Schema::create('candidates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
              ->constrained()
              ->cascadeOnDelete();

        // Public profile fields
        $table->string('name');
        $table->string('slug')->unique(); // for site_url/name
        $table->string('email')->unique();
        $table->string('phone')->nullable();
        $table->string('title')->nullable();

        $table->string('district');
        $table->string('state');
        $table->enum('gender', ['male', 'female', 'other'])->nullable();

        $table->text('bio')->nullable();
        $table->string('photo')->nullable();

        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidates');
    }
};
