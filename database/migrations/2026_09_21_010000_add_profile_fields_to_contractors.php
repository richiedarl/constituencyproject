<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contractors', function (Blueprint $table) {
            $table->string('company_name')->nullable()->unique()->after('slug');
            $table->unsignedInteger('experience_years')->default(0)->after('occupation');
            $table->boolean('verified')->default(false)->after('approved');
            $table->timestamp('verified_at')->nullable()->after('verified');
            $table->foreignId('verified_by')->nullable()->after('verified_at')->constrained('users')->nullOnDelete();
            $table->boolean('suspended')->default(false)->after('verified_by');
            $table->timestamp('suspended_at')->nullable()->after('suspended');
            $table->foreignId('suspended_by')->nullable()->after('suspended_at')->constrained('users')->nullOnDelete();
            $table->text('suspension_reason')->nullable()->after('suspended_by');
        });
    }

    public function down(): void
    {
        Schema::table('contractors', function (Blueprint $table) {
            $table->dropForeign(['verified_by']);
            $table->dropForeign(['suspended_by']);
            $table->dropUnique(['company_name']);
            $table->dropColumn([
                'company_name', 'experience_years', 'verified', 'verified_at',
                'verified_by', 'suspended', 'suspended_at', 'suspended_by',
                'suspension_reason',
            ]);
        });
    }
};
