<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('updates', function (Blueprint $table) {
            // Add missing columns if they don't exist
            if (!Schema::hasColumn('updates', 'phase_id')) {
                $table->foreignId('phase_id')->nullable()->constrained('project_phases')->onDelete('cascade');
            }

            if (!Schema::hasColumn('updates', 'project_id')) {
                $table->foreignId('project_id')->nullable()->constrained()->onDelete('cascade');
            }

            if (!Schema::hasColumn('updates', 'contractor_id')) {
                $table->foreignId('contractor_id')->nullable()->constrained()->onDelete('cascade');
            }

            if (!Schema::hasColumn('updates', 'report_date')) {
                $table->date('report_date')->nullable();
            }

            if (!Schema::hasColumn('updates', 'photo')) {
                $table->string('photo')->nullable();
            }

            if (!Schema::hasColumn('updates', 'comment')) {
                $table->text('comment')->nullable();
            }

            if (!Schema::hasColumn('updates', 'status')) {
                $table->string('status')->default('pending');
            }

            if (!Schema::hasColumn('updates', 'approved_by')) {
                $table->foreignId('approved_by')->nullable()->constrained('users');
            }

            if (!Schema::hasColumn('updates', 'approved_at')) {
                $table->timestamp('approved_at')->nullable();
            }

            // Add indexes for better performance
            $table->index('phase_id');
            $table->index('project_id');
            $table->index('contractor_id');
            $table->index('report_date');
            $table->index('status');
        });
    }

    public function down()
    {
        Schema::table('updates', function (Blueprint $table) {
            $table->dropForeign(['phase_id']);
            $table->dropForeign(['project_id']);
            $table->dropForeign(['contractor_id']);
            $table->dropForeign(['approved_by']);

            $table->dropColumn([
                'phase_id',
                'project_id',
                'contractor_id',
                'report_date',
                'photo',
                'comment',
                'status',
                'approved_by',
                'approved_at'
            ]);
        });
    }
};
