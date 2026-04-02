<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('shifts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('weekly_schedule_assignment_id')->nullable();
            $table->unsignedBigInteger('employee_id');
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->time('break_start')->nullable();
            $table->time('lunch_start')->nullable();
            $table->string('status', 20)->default('draft');
            $table->timestampTz('published_at')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestampsTz();

            $table->unique(['employee_id', 'date']);

            $table->foreign('weekly_schedule_assignment_id')
                ->references('id')->on('weekly_schedule_assignments')
                ->onDelete('cascade');

            $table->foreign('employee_id')
                ->references('id')->on('employees')
                ->onDelete('cascade');

            $table->foreign('created_by')
                ->references('id')->on('users')
                ->nullOnDelete();

            // Indexes (from 2026_04_01_000005)
            $table->index('employee_id', 'shifts_employee_idx');
            $table->index('date', 'shifts_date_idx');
        });
    }

    public function down(): void {
        Schema::dropIfExists('shifts');
    }
};
