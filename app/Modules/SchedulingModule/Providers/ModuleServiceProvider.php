<?php

namespace App\Modules\SchedulingModule\Providers;

use App\Modules\SchedulingModule\Models\BreakTemplate;
use App\Modules\SchedulingModule\Models\Schedule;
use App\Modules\SchedulingModule\Policies\BreakTemplatePolicy;
use App\Modules\SchedulingModule\Policies\SchedulePolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider {
    public function register(): void {
        // Registro de bindings del módulo
    }

    public function boot(): void {
        // Registro de rutas, vistas, etc.
        if (file_exists(__DIR__ . '/../Routes/web.php')) {
            $this->loadRoutesFrom(__DIR__ . '/../Routes/web.php');
        }

        if (is_dir(__DIR__ . '/../Resources/Views')) {
            $this->loadViewsFrom(__DIR__ . '/../Resources/Views', 'scheduling');
        }

        $this->registerPolicies();
        $this->registerLivewireComponents();
    }

    private function registerLivewireComponents(): void {
        if (class_exists(\Livewire\Livewire::class)) {
            \Livewire\Livewire::component('scheduling.create-break-template', \App\Modules\SchedulingModule\Livewire\CreateBreakTemplate::class);
        }
    }

    private function registerPolicies(): void {
        Gate::policy(Schedule::class, SchedulePolicy::class);
        Gate::policy(BreakTemplate::class, BreakTemplatePolicy::class);
    }
}
