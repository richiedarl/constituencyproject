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
        Schema::table('contacts', function (Blueprint $table) {
            // Add new columns if they don't exist
            if (!Schema::hasColumn('contacts', 'phone')) {
                $table->string('phone')->nullable()->after('email');
            }

            if (!Schema::hasColumn('contacts', 'candidate_id')) {
                $table->foreignId('candidate_id')->nullable()->constrained()->onDelete('set null')->after('phone');
            }

            if (!Schema::hasColumn('contacts', 'type')) {
                $table->string('type')->default('general')->index()->after('candidate_id');
            }

            if (!Schema::hasColumn('contacts', 'status')) {
                $table->string('status')->default('pending')->index()->after('type');
            }

            if (!Schema::hasColumn('contacts', 'admin_notes')) {
                $table->text('admin_notes')->nullable()->after('status');
            }

            if (!Schema::hasColumn('contacts', 'approved_at')) {
                $table->timestamp('approved_at')->nullable()->after('admin_notes');
            }

            if (!Schema::hasColumn('contacts', 'approved_by')) {
                $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null')->after('approved_at');
            }

            if (!Schema::hasColumn('contacts', 'rejected_at')) {
                $table->timestamp('rejected_at')->nullable()->after('approved_by');
            }

            if (!Schema::hasColumn('contacts', 'rejected_by')) {
                $table->foreignId('rejected_by')->nullable()->constrained('users')->onDelete('set null')->after('rejected_at');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropForeign(['candidate_id']);
            $table->dropForeign(['approved_by']);
            $table->dropForeign(['rejected_by']);

            $table->dropColumn([
                'phone',
                'candidate_id',
                'type',
                'status',
                'admin_notes',
                'approved_at',
                'approved_by',
                'rejected_at',
                'rejected_by'
            ]);
        });
    }
};
