<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            if (!Schema::hasColumn('employees', 'team_id')) {
                $table->foreignId('team_id')->nullable()->constrained('teams')->onDelete('set null');
            }

            if (!Schema::hasColumn('employees', 'deleted_at')) {
                $table->softDeletes();
            }

            $table->index(['team_id', 'employment_status_id', 'deleted_at'], 'employees_team_status_deleted_idx');
        });

        Schema::table('employment_statuses', function (Blueprint $table) {
            if (!Schema::hasColumn('employment_statuses', 'parent_id')) {
                $table->foreignId('parent_id')->nullable()->constrained('employment_statuses')->onDelete('set null');
            }

            $table->index(['parent_id'], 'employment_statuses_parent_idx');
        });
    }

    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropIndex('employees_team_status_deleted_idx');

            if (Schema::hasColumn('employees', 'team_id')) {
                $table->dropForeign(['team_id']);
                $table->dropColumn('team_id');
            }

            if (Schema::hasColumn('employees', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
        });

        Schema::table('employment_statuses', function (Blueprint $table) {
            $table->dropIndex('employment_statuses_parent_idx');

            if (Schema::hasColumn('employment_statuses', 'parent_id')) {
                $table->dropForeign(['parent_id']);
                $table->dropColumn('parent_id');
            }
        });
    }
};