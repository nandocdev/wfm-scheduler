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

// Departments
Route::get('departments', App\Modules\OrganizationModule\Livewire\ListDepartments::class)->name('departments.index');
Route::get('departments/create', App\Modules\OrganizationModule\Livewire\CreateDepartment::class)->name('departments.create');

// Positions
Route::get('positions', App\Modules\OrganizationModule\Livewire\ListPositions::class)->name('positions.index');
Route::get('positions/create', App\Modules\OrganizationModule\Livewire\CreatePosition::class)->name('positions.create');

// Teams
Route::get('teams', App\Modules\OrganizationModule\Livewire\ListTeams::class)->name('teams.index');
Route::get('teams/create', App\Modules\OrganizationModule\Livewire\CreateTeam::class)->name('teams.create');
