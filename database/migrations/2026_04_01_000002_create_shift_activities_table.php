<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('shift_activities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('shift_id');
            $table->string('activity_type', 30);
            $table->unsignedSmallInteger('start_slot');
            $table->unsignedSmallInteger('end_slot');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestampsTz();

            $table->foreign('shift_id')
                ->references('id')->on('shifts')
                ->onDelete('cascade');

            $table->foreign('created_by')
                ->references('id')->on('users')
                ->nullOnDelete();
        });

        // Add CHECK constraint if supported by the connection
        $driver = DB::getDriverName();
        if (in_array($driver, ['pgsql', 'mysql'])) {
            DB::statement('ALTER TABLE shift_activities ADD CONSTRAINT shift_activity_slot_check CHECK (start_slot >= 0 AND end_slot <= 288 AND start_slot < end_slot)');
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('shift_activities');
    }
};
