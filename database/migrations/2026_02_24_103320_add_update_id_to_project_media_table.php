<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('project_media', function (Blueprint $table) {
            if (!Schema::hasColumn('project_media', 'update_id')) {
                $table->foreignId('update_id')->nullable()->after('project_phase_id')->constrained()->onDelete('cascade');
            }
            if (!Schema::hasColumn('project_media', 'uploaded_by')) {
                $table->foreignId('uploaded_by')->nullable()->after('update_id')->constrained('users')->onDelete('set null');
            }
        });
    }

    public function down(): void
    {
        Schema::table('project_media', function (Blueprint $table) {
            $table->dropForeign(['update_id']);
            $table->dropForeign(['uploaded_by']);
            $table->dropColumn(['update_id', 'uploaded_by']);
        });
    }
};
