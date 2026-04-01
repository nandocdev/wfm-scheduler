<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * This migration creates the base tables for the scheduling module:
     * - weekly_schedules: Container for weekly planning periods
     * - weekly_schedule_assignments: Link employees to schedule templates for a week
     *
     * Note: Activity-level details (shifts, shift_activities) are managed in separate migrations
     * using 5-minute slot granularity for coverage validation.
     */
    public function up(): void {
        // 1. Weekly Schedules — Container for planning periods
        Schema::create('weekly_schedules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->date('start_date');
            $table->date('end_date');
            $table->string('status', 20)->default('draft'); // draft, published, locked
            $table->timestampsTz();
        });

        // Add exclusion constraint to prevent overlapping weekly schedules by date range
        // Only apply when using PostgreSQL (SQLite in-memory for tests does not support extensions)
        if (config('database.default') === 'pgsql') {
            DB::statement("CREATE EXTENSION IF NOT EXISTS btree_gist;");
            DB::statement(<<<'SQL'
                ALTER TABLE weekly_schedules
                ADD CONSTRAINT weekly_schedules_no_overlap
                EXCLUDE USING gist (daterange(start_date, end_date, '[]') WITH &&);
            SQL
            );
        }

        // 2. Weekly Schedule Assignments — Assign employees to a schedule template for a week
        Schema::create('weekly_schedule_assignments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('weekly_schedule_id');
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('schedule_id')->nullable();
            $table->date('assignment_date');
            $table->boolean('is_manual')->default(false);
            $table->timestampsTz();

            $table->unique(['weekly_schedule_id', 'employee_id', 'assignment_date']);

            $table->foreign('weekly_schedule_id')
                ->references('id')->on('weekly_schedules')
                ->onDelete('cascade');

            $table->foreign('employee_id')
                ->references('id')->on('employees')
                ->onDelete('cascade');

            $table->foreign('schedule_id')
                ->references('id')->on('schedules')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('weekly_schedule_assignments');
        Schema::dropIfExists('weekly_schedules');
    }
};
