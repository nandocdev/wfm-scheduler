<?php

use App\Modules\OrganizationModule\Http\Controllers\DirectorateController;
use App\Modules\OrganizationModule\Http\Controllers\DepartmentController;
use App\Modules\OrganizationModule\Http\Controllers\PositionController;
use App\Modules\OrganizationModule\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Organization Module Routes
|--------------------------------------------------------------------------
|
| Rutas para el módulo de organización.
| Prefijo: organization.*
|
*/

// Directorates
Route::get('directorates', App\Modules\OrganizationModule\Livewire\ListDirectorates::class)->name('directorates.index');
Route::get('directorates/create', App\Modules\OrganizationModule\Livewire\CreateDirectorate::class)->name('directorates.create');
Route::get('directorates/{directorate}', App\Modules\OrganizationModule\Livewire\ShowDirectorate::class)->name('directorates.show');
Route::get('directorates/{directorate}/edit', App\Modules\OrganizationModule\Livewire\EditDirectorate::class)->name('directorates.edit');

// Departments
Route::get('departments', App\Modules\OrganizationModule\Livewire\ListDepartments::class)->name('departments.index');
Route::get('departments/create', App\Modules\OrganizationModule\Livewire\CreateDepartment::class)->name('departments.create');
Route::get('departments/{department}', App\Modules\OrganizationModule\Livewire\ShowDepartment::class)->name('departments.show');
Route::get('departments/{department}/edit', App\Modules\OrganizationModule\Livewire\EditDepartment::class)->name('departments.edit');

// Positions
Route::get('positions', App\Modules\OrganizationModule\Livewire\ListPositions::class)->name('positions.index');
Route::get('positions/create', App\Modules\OrganizationModule\Livewire\CreatePosition::class)->name('positions.create');
Route::get('positions/{position}', App\Modules\OrganizationModule\Livewire\ShowPosition::class)->name('positions.show');
Route::get('positions/{position}/edit', App\Modules\OrganizationModule\Livewire\EditPosition::class)->name('positions.edit');

// Teams
Route::get('teams', App\Modules\OrganizationModule\Livewire\ListTeams::class)->name('teams.index');
Route::get('teams/create', App\Modules\OrganizationModule\Livewire\CreateTeam::class)->name('teams.create');
Route::get('teams/{team}', App\Modules\OrganizationModule\Livewire\ShowTeam::class)->name('teams.show');
Route::get('teams/{team}/edit', App\Modules\OrganizationModule\Livewire\EditTeam::class)->name('teams.edit');
