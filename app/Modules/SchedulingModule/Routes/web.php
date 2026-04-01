<?php

use Illuminate\Support\Facades\Route;
use App\Modules\SchedulingModule\Livewire\AssignGrid;

Route::middleware(['web', 'auth'])
    ->prefix('scheduling')
    ->name('scheduling.')
    ->group(function () {
        // Livewire grid for bulk assignment (UI)
        Route::get('assign-grid/{weekly_schedule_id?}', AssignGrid::class)
            ->name('assign_grid');
    });
