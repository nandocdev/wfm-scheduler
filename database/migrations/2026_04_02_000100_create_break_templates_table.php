<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('break_templates', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('schedule_id')->constrained('schedules')->cascadeOnDelete();
            $table->string('name', 150);
            $table->time('start_time');
            $table->unsignedSmallInteger('duration_minutes');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['schedule_id', 'name'], 'break_templates_schedule_name_unique');
            $table->index(['schedule_id', 'start_time'], 'break_templates_schedule_start_idx');
        });

        if (in_array(DB::getDriverName(), ['pgsql', 'mysql'], true)) {
            DB::statement(
                'ALTER TABLE break_templates ADD CONSTRAINT break_templates_duration_positive_check CHECK (duration_minutes > 0 AND duration_minutes <= 480)'
            );
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('break_templates');
    }
};
