<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->unsignedBigInteger('project_id')->nullable()->change();
            $table->unsignedBigInteger('contractor_id')->nullable()->change();
            $table->unsignedBigInteger('contributor_id')->nullable()->change();
            $table->unsignedBigInteger('candidate_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->unsignedBigInteger('project_id')->nullable(false)->change();
            $table->unsignedBigInteger('contractor_id')->nullable(false)->change();
            $table->unsignedBigInteger('contributor_id')->nullable(false)->change();
            $table->unsignedBigInteger('candidate_id')->nullable(false)->change();
        });
    }
};
