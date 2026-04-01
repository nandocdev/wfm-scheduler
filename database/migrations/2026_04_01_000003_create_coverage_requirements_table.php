<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('coverage_requirements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('team_id');
            $table->date('date');
            $table->unsignedSmallInteger('slot_index');
            $table->unsignedSmallInteger('required_min')->default(0);
            $table->timestampsTz();

            $table->unique(['team_id', 'date', 'slot_index']);

            $table->foreign('team_id')
                ->references('id')->on('teams')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coverage_requirements');
    }
};
