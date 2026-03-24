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
Route::resource('directorates', DirectorateController::class);

// Departments
Route::resource('departments', DepartmentController::class);

// Positions
Route::resource('positions', PositionController::class);

// Teams
Route::resource('teams', TeamController::class);
