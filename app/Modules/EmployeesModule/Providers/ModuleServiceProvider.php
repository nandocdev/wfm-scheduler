<?php

namespace App\Modules\EmployeesModule\Providers;

use App\Modules\EmployeesModule\Models\Employee;
use App\Modules\EmployeesModule\Observers\EmployeeObserver;
use App\Modules\EmployeesModule\Policies\EmployeePolicy;
use App\Modules\EmployeesModule\Livewire\CreateEmployee;
use App\Modules\EmployeesModule\Livewire\ListEmployees;
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
    public function boot(): void {
        $this->registerRoutes();
        $this->registerObservers();
        $this->registerPolicies();
        $this->registerLivewireComponents();
        $this->loadViews();
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

    private function registerLivewireComponents(): void {
        Livewire::component('employees::list-employees', ListEmployees::class);
        Livewire::component('employees::create-employee', CreateEmployee::class);
    }

    private function loadViews(): void {
        $this->loadViewsFrom(
            __DIR__ . '/../Resources/Views',
            'employees'
        );
    }
}
