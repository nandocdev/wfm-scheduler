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

        // Index route for break templates (needed by redirects)
        Route::get('break-templates', function () {
            return view('scheduling::index-break-templates');
        })->name('break_templates.index');

        // Livewire grid for bulk assignment (UI)
        Route::get('assign-grid/{weekly_schedule_id?}', AssignGrid::class)
            ->name('assign_grid');
    });
