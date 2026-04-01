<?php

use App\Modules\SchedulingModule\Http\Controllers\BreakTemplateController;
use Illuminate\Support\Facades\Route;
use App\Modules\SchedulingModule\Livewire\AssignGrid;

Route::middleware(['web', 'auth'])
    ->prefix('scheduling')
    ->name('scheduling.')
    ->group(function () {
        Route::get('break-templates/create', [BreakTemplateController::class, 'create'])
            ->name('break_templates.create');

        // Livewire grid for bulk assignment (UI)
        Route::get('assign-grid/{weekly_schedule_id?}', AssignGrid::class)
            ->name('assign_grid');
    });
