<?php

declare(strict_types=1);

use App\Modules\CommunicationsModule\Livewire\CreateNews;
use App\Modules\CommunicationsModule\Livewire\EditNews;
use App\Modules\CommunicationsModule\Livewire\ListNews;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('admin/communications')->name('communications.')->group(function () {
    // Noticias
    Route::get('/news', ListNews::class)->name('news.index');
    Route::get('/news/create', CreateNews::class)->name('news.create');
    Route::get('/news/{news}/edit', EditNews::class)->name('news.edit');
});
