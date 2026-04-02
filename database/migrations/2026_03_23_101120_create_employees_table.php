<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('employee_number', 20)->unique();
            $table->string('username')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->date('birth_date')->nullable();
            $table->string('gender', 10)->nullable();
            $table->string('blood_type', 5)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('mobile_phone', 20)->nullable();
            $table->text('address')->nullable();

            // Relaciones geográficas
            $table->foreignId('township_id')->nullable()->constrained()->onDelete('set null');

            // Relaciones organizacionales
            $table->foreignId('department_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('position_id')->nullable()->constrained()->onDelete('restrict');
            $table->foreignId('employment_status_id')->nullable()->constrained()->onDelete('set null');

            // Jerarquía (Adjacency List)
            $table->foreignId('parent_id')->nullable()->constrained('employees')->onDelete('set null');

            // Relación con Usuario del Sistema
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');

            // Team assignment (from 2026_03_30_090000)
            $table->foreignId('team_id')->nullable()->constrained('teams')->onDelete('set null');

            // Datos laborales
            $table->date('hire_date')->nullable();
            $table->decimal('salary', 12, 2)->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_manager')->default(false);
            $table->jsonb('metadata')->nullable();

            // Soft delete (from 2026_03_30_090000)
            $table->softDeletes();

            $table->timestamps();

            // Índice para team/status queries (from 2026_03_30_090000)
            $table->index(['team_id', 'employment_status_id', 'deleted_at'], 'employees_team_status_deleted_idx');
        });

        // Add supervisor_id to teams (from 2026_03_25_151402 consolidated here)
        Schema::table('teams', function (Blueprint $table) {
            $table->foreignId('supervisor_id')->nullable()->constrained('employees')->nullOnDelete();
        });

        // Add parent_id index to employment_statuses (from 2026_03_30_090000)
        Schema::table('employment_statuses', function (Blueprint $table) {
            $table->index(['parent_id'], 'employment_statuses_parent_idx');
        });

        // Restricción adicional: parent_id no puede ser igual a id (Check constraint)
        DB::statement('ALTER TABLE employees ADD CONSTRAINT employees_parent_not_self CHECK (parent_id <> id)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('employees');
    }
};
