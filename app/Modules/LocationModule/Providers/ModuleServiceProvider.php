<?php

namespace App\Modules\LocationModule\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider {
    public function boot(): void {
        $this->registerRoutes();
        $this->loadViews();
    }

    private function registerRoutes(): void {
        Route::middleware('web')
            ->prefix('locations')
            ->name('locations.')
            ->group(__DIR__ . '/../Routes/web.php');
    }

    private function loadViews(): void {
        $this->loadViewsFrom(
            __DIR__ . '/../Resources/Views',
            'locations'
        );
    }
}
