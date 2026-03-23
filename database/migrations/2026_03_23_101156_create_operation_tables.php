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
        // 1. Intraday Activities
        Schema::create('intraday_activities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code', 50)->unique();
            $table->string('color')->default('blue');
            $table->boolean('is_paid')->default(true);
            $table->timestamps();
        });

        // 2. Intraday Activity Assignments
        Schema::create('intraday_activity_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->foreignId('intraday_activity_id')->constrained()->onDelete('cascade');
            $table->dateTime('start_time');
            $table->dateTime('end_time')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // 3. Attendance Incidents
        Schema::create('attendance_incidents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->foreignId('incident_type_id')->constrained()->onDelete('cascade');
            $table->date('incident_date');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->text('user_comment')->nullable();
            $table->text('admin_comment')->nullable();
            $table->timestamps();
            
            $table->unique(['employee_id', 'incident_type_id', 'incident_date']);
        });

        // 4. Leave Requests
        Schema::create('leave_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->string('type', 20)->default('full'); // full, partial
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->string('status', 20)->default('pending'); // pending, approved, rejected, cancelled
            $table->text('reason')->nullable();
            $table->timestamps();
        });

        // 5. Shift Swap Requests
        Schema::create('shift_swap_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('requester_id')->constrained('employees')->onDelete('cascade');
            $table->foreignId('recipient_id')->constrained('employees')->onDelete('cascade');
            $table->date('requested_date');
            $table->string('status', 20)->default('pending'); // pending, accepted, rejected, approved, cancelled
            $table->text('reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shift_swap_requests');
        Schema::dropIfExists('leave_requests');
        Schema::dropIfExists('attendance_incidents');
        Schema::dropIfExists('intraday_activity_assignments');
        Schema::dropIfExists('intraday_activities');
    }
};
