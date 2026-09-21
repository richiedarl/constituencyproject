<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('wallets', function (Blueprint $table) {
            $table->integer('candidate_id')->nullable()->change();
            $table->unsignedBigInteger('contractor_id')->nullable()->after('candidate_id');
            $table->unsignedBigInteger('contributor_id')->nullable()->after('contractor_id');
            $table->unsignedBigInteger('admin_id')->nullable()->after('contributor_id');
        });
    }

    public function down(): void
    {
        Schema::table('wallets', function (Blueprint $table) {
            $table->dropColumn(['contractor_id', 'contributor_id', 'admin_id']);
            $table->integer('candidate_id')->nullable(false)->change();
        });
    }
};
