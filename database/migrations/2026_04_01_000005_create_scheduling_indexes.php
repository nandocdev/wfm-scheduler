<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Create indexes for scheduling module optimizations.
     *
     * These indexes optimize:
     * - Coverage queries: by team/date for aggregation
     * - Shift lookups: by employee and date
     * - Activity slot tracking: for overlap detection
     */
    public function up(): void
    {
        // Index shifts for fast lookups by employee/date and team/date joins
        if (! $this->indexExists('shifts', 'shifts_employee_idx')) {
            Schema::table('shifts', function (Blueprint $table) {
                $table->index('employee_id', 'shifts_employee_idx');
            });
        }

        // Index for team-date coverage queries (join via employees.team_id)
        if (! $this->indexExists('shifts', 'shifts_date_idx')) {
            Schema::table('shifts', function (Blueprint $table) {
                $table->index('date', 'shifts_date_idx');
            });
        }

        // Index shift_activities for slot-based lookups
        if (! $this->indexExists('shift_activities', 'shift_activities_shift_idx')) {
            Schema::table('shift_activities', function (Blueprint $table) {
                $table->index('shift_id', 'shift_activities_shift_idx');
            });
        }

        // Index for slot range queries (overlap detection)
        if (! $this->indexExists('shift_activities', 'shift_activities_slot_idx')) {
            Schema::table('shift_activities', function (Blueprint $table) {
                $table->index(['start_slot', 'end_slot'], 'shift_activities_slot_idx');
            });
        }

        // Index coverage requirements for team/date lookups
        if (! $this->indexExists('coverage_requirements', 'coverage_requirements_team_date_idx')) {
            Schema::table('coverage_requirements', function (Blueprint $table) {
                $table->index(['team_id', 'date'], 'coverage_requirements_team_date_idx');
            });
        }

        // Index coverage snapshots for team/date reporting
        if (! $this->indexExists('coverage_snapshots', 'coverage_snapshots_team_date_idx')) {
            Schema::table('coverage_snapshots', function (Blueprint $table) {
                $table->index(['team_id', 'date'], 'coverage_snapshots_team_date_idx');
            });
        }
    }

    public function down(): void
    {
        Schema::table('coverage_snapshots', function (Blueprint $table) {
            $table->dropIndex('coverage_snapshots_team_date_idx');
        });

        Schema::table('coverage_requirements', function (Blueprint $table) {
            $table->dropIndex('coverage_requirements_team_date_idx');
        });

        Schema::table('shift_activities', function (Blueprint $table) {
            $table->dropIndex('shift_activities_slot_idx');
            $table->dropIndex('shift_activities_shift_idx');
        });

        Schema::table('shifts', function (Blueprint $table) {
            $table->dropIndex('shifts_date_idx');
            $table->dropIndex('shifts_employee_idx');
        });
    }

    /**
     * Check if an index exists on a table.
     */
    private function indexExists(string $table, string $indexName): bool
    {
        $result = DB::select("SELECT COUNT(*) as count FROM information_schema.statistics WHERE table_schema = DATABASE() AND table_name = ? AND index_name = ?", [$table, $indexName]);
        return $result[0]->count > 0;
    }
};
