<?php

use App\Modules\SchedulingModule\Models\WeeklySchedule;

it('prevents overlapping weekly schedules at DB level', function () {
    WeeklySchedule::create([
        'name' => 'week-a',
        'start_date' => '2026-04-01',
        'end_date' => '2026-04-07',
    ]);

    expect(fn () => WeeklySchedule::create([
        'name' => 'week-b',
        'start_date' => '2026-04-05',
        'end_date' => '2026-04-11',
    ]))->toThrow(Illuminate\Database\QueryException::class);
});
