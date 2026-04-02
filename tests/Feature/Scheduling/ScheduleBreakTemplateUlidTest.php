<?php

use App\Modules\SchedulingModule\Models\BreakTemplate;
use App\Modules\SchedulingModule\Models\Schedule;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('creates schedule and break template with bigint primary keys and proper relation', function () {
    $schedule = Schedule::create([
        'name' => 'Gran Turno',
        'start_time' => '08:00:00',
        'end_time' => '17:00:00',
        'lunch_minutes' => 60,
        'break_minutes' => 30,
        'total_minutes' => 540,
        'is_active' => true,
    ]);

    expect($schedule->id)->toBeInt();
    expect($schedule->fresh()->id)->toBe($schedule->id);

    $breakTemplate = BreakTemplate::create([
        'schedule_id' => $schedule->id,
        'name' => 'Almuerzo largo',
        'start_time' => '12:00:00',
        'duration_minutes' => 60,
        'is_active' => true,
    ]);

    expect($breakTemplate->id)->toBeInt();
    expect($breakTemplate->schedule->id)->toBe($schedule->id);
    expect($schedule->breakTemplates()->first()->id)->toBe($breakTemplate->id);
});
