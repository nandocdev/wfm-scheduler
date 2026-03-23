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
        // 1. Leave Request Approvals
        Schema::create('leave_request_approvals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('leave_request_id')->constrained()->onDelete('cascade');
            $table->foreignId('approver_id')->constrained('employees')->onDelete('cascade');
            $table->string('status', 20); // approved, rejected
            $table->text('comment')->nullable();
            $table->integer('step_order')->default(1);
            $table->timestamps();
        });

        // 2. Shift Swap Approvals
        Schema::create('shift_swap_approvals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shift_swap_request_id')->constrained()->onDelete('cascade');
            $table->foreignId('approver_id')->constrained('employees')->onDelete('cascade');
            $table->string('status', 20); // approved, rejected
            $table->text('comment')->nullable();
            $table->integer('step_order')->default(1);
            $table->timestamps();
        });

        // 3. Audit Logs
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->string('entity_type');
            $table->unsignedBigInteger('entity_id');
            $table->string('action'); // created, updated, deleted, login, etc.
            $table->jsonb('before')->nullable();
            $table->jsonb('after')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps();
            
            $table->index(['entity_type', 'entity_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
        Schema::dropIfExists('shift_swap_approvals');
        Schema::dropIfExists('leave_request_approvals');
    }
};
