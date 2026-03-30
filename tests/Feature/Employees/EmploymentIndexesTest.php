<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

it('has team_id, deleted_at and composite index on employees and parent index on employment_statuses', function () {
    expect(Schema::hasColumn('employees', 'team_id'))->toBeTrue();
    expect(Schema::hasColumn('employees', 'deleted_at'))->toBeTrue();
    expect(Schema::hasColumn('employment_statuses', 'parent_id'))->toBeTrue();

    $employeesIndexes = collect(DB::select("SELECT indexname FROM pg_indexes WHERE tablename = 'employees';"))->pluck('indexname')->toArray();
    expect(in_array('employees_team_status_deleted_idx', $employeesIndexes))->toBeTrue();

    $statusIndexes = collect(DB::select("SELECT indexname FROM pg_indexes WHERE tablename = 'employment_statuses';"))->pluck('indexname')->toArray();
    expect(in_array('employment_statuses_parent_idx', $statusIndexes))->toBeTrue();
});