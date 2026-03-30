<?php

use App\Modules\LocationModule\Http\Controllers\LocationController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LocationController::class, 'index'])->name('index');
Route::get('/provinces', [LocationController::class, 'provinces'])->name('provinces');
Route::get('/districts/{province}', [LocationController::class, 'districts'])->name('districts');
Route::get('/townships/{district}', [LocationController::class, 'townships'])->name('townships');
