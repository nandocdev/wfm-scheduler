<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('coverage_snapshots', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('team_id');
            $table->date('date');
            $table->unsignedSmallInteger('slot_index');
            $table->integer('assigned_count');
            $table->integer('required_min');
            $table->boolean('deficit');
            $table->timestampTz('created_at')->useCurrent();

            $table->unique(['team_id', 'date', 'slot_index']);

            $table->foreign('team_id')
                ->references('id')->on('teams')
                ->onDelete('cascade');
            
            // Index (from 2026_04_01_000005)
            $table->index(['team_id', 'date'], 'coverage_snapshots_team_date_idx');
        });
    }

    public function down(): void {
        Schema::dropIfExists('coverage_snapshots');
    }
};
