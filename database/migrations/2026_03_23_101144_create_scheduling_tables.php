<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        // 1. Weekly Schedules
        Schema::create('weekly_schedules', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('name')->unique();
            $table->date('start_date');
            $table->date('end_date');
            $table->string('status', 20)->default('draft'); // draft, published, locked
            $table->timestamps();
        });

        // 2. Weekly Schedule Assignments (F: weekly_schedules, employees, schedules)
        Schema::create('weekly_schedule_assignments', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('weekly_schedule_id')->constrained()->onDelete('cascade');
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->foreignUlid('schedule_id')->nullable()->constrained()->onDelete('set null');
            $table->date('assignment_date');
            $table->boolean('is_manual')->default(false);
            $table->timestamps();

            $table->unique(['weekly_schedule_id', 'employee_id', 'assignment_date']);
        });

        // 3. Break Templates
        Schema::create('break_templates', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('schedule_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->time('start_time');
            $table->integer('duration_minutes');
            $table->timestamps();
            $table->unique(['schedule_id', 'name']);
        });

        // 4. Employee Break Overrides
        Schema::create('employee_break_overrides', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('weekly_schedule_assignment_id')->constrained()->onDelete('cascade');
            $table->time('start_time');
            $table->integer('duration_minutes');
            $table->text('reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('employee_break_overrides');
        Schema::dropIfExists('break_templates');
        Schema::dropIfExists('weekly_schedule_assignments');
        Schema::dropIfExists('weekly_schedules');
    }
};
