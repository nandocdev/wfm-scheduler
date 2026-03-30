<?php

use App\Modules\EmployeesModule\Livewire\ListEmployees;
use App\Modules\EmployeesModule\Models\Employee;
use App\Modules\EmployeesModule\Models\EmploymentStatus;
use App\Modules\OrganizationModule\Models\Department;
use App\Modules\OrganizationModule\Models\Position;
use App\Modules\OrganizationModule\Models\Team;
use Illuminate\Support\Facades\DB;
use Livewire\Livewire;

it('keeps query growth bounded with eager loading in server-side pagination', function () {
    $team = Team::factory()->create();
    $department = Department::factory()->create();
    $position = Position::factory()->create(['department_id' => $department->id]);
    $status = EmploymentStatus::factory()->create();

    Employee::factory()->count(2)->create([
        'team_id' => $team->id,
        'department_id' => $department->id,
        'position_id' => $position->id,
        'employment_status_id' => $status->id,
    ]);

    DB::flushQueryLog();
    DB::enableQueryLog();

    Livewire::test(ListEmployees::class)
        ->set('perPage', 15)
        ->assertOk();

    $queriesWith2 = count(DB::getQueryLog());

    Employee::factory()->count(13)->create([
        'team_id' => $team->id,
        'department_id' => $department->id,
        'position_id' => $position->id,
        'employment_status_id' => $status->id,
    ]);

    DB::flushQueryLog();
    DB::enableQueryLog();

    Livewire::test(ListEmployees::class)
        ->set('perPage', 15)
        ->assertOk();

    $queriesWith15 = count(DB::getQueryLog());

    expect($queriesWith15 - $queriesWith2)->toBeLessThan(4);
});
