<?php

namespace App\Modules\EmployeesModule\Providers;

use App\Modules\EmployeesModule\Models\Employee;
use App\Modules\EmployeesModule\Observers\EmployeeObserver;
use App\Modules\EmployeesModule\Policies\EmployeePolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

/**
 * Registra todos los componentes del módulo Employees.
 * Este provider debe estar listado en bootstrap/providers.php
 *
 * @module EmployeesModule
 * @type ServiceProvider
 * @author GitHub Copilot
 * @created 2026-03-25
 */
class ModuleServiceProvider extends ServiceProvider {
    public function register(): void {
        // Registrar componentes Livewire en register() para asegurar que estén disponibles temprano
        $this->registerLivewireComponents();
    }

    public function boot(): void {
        $this->registerRoutes();
        $this->registerObservers();
        $this->registerPolicies();
        $this->loadViews();
    }

    private function registerLivewireComponents(): void {
        // Configurar namespace para componentes Livewire del módulo
        Livewire::component('employees::list-employees', \App\Modules\EmployeesModule\Livewire\ListEmployees::class);
        Livewire::component('employees::create-employee', \App\Modules\EmployeesModule\Livewire\CreateEmployee::class);
        Livewire::component('employees::edit-employee', \App\Modules\EmployeesModule\Livewire\EditEmployee::class);
    }

    private function registerRoutes(): void {
        Route::middleware(['web', 'auth'])
            ->prefix('employees')
            ->name('employees.')
            ->group(__DIR__ . '/../Routes/web.php');
    }

    private function registerObservers(): void {
        Employee::observe(EmployeeObserver::class);
    }

    private function registerPolicies(): void {
        Gate::policy(Employee::class, EmployeePolicy::class);
    }

    private function loadViews(): void {
        $this->loadViewsFrom(
            __DIR__ . '/../Resources/Views',
            'employees'
        );
    }
}
