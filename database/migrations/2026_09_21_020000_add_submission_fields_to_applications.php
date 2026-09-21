<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->decimal('expected_rate', 15, 2)->nullable()->after('cover_letter');
            $table->timestamp('applied_at')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn(['expected_rate', 'applied_at']);
        });
    }
};
