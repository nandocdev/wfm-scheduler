<?php

declare(strict_types=1);

use App\Modules\SchedulingModule\Livewire\AssignGrid;
use App\Modules\SchedulingModule\Livewire\CreateBreakTemplate;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth'])
    ->prefix('scheduling')
    ->name('scheduling.')
    ->group(function () {
        Route::get('break-templates/create', CreateBreakTemplate::class)
            ->name('break_templates.create');

        Route::get('assign-grid/{weekly_schedule_id?}', AssignGrid::class)
            ->name('assign_grid');
    });
