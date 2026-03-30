<?php

use App\Modules\SchedulingModule\Http\Controllers\BreakTemplateController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth'])
    ->prefix('scheduling')
    ->name('scheduling.')
    ->group(function () {
        Route::get('break-templates/create', [BreakTemplateController::class, 'create'])
            ->name('break_templates.create');
    });
