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
        // Registro de bindings del módulo
    }

    public function boot(): void {
        // 1. Carga de infraestructura modular
        $this->registerInfrastructure();

        // 2. Autorización
        $this->registerPolicies();

        // 3. Carga de vistas con namespace
        $this->loadViews();
    }

    /**
     * Registra rutas, vistas y namespaces del módulo.
     */
    protected function registerInfrastructure(): void {
        $viewsPath = __DIR__ . '/../Resources/Views';

        if (file_exists(__DIR__ . '/../Routes/web.php')) {
            Route::middleware(['web', 'auth'])
                ->prefix('employees')
                ->name('employees.')
                ->group(__DIR__ . '/../Routes/web.php');
        }

        if (is_dir($viewsPath)) {
            // Registro manual de componentes para control granular
            Livewire::component('employees.list-employees', \App\Modules\EmployeesModule\Livewire\ListEmployees::class);
            Livewire::component('employees.create-employee', \App\Modules\EmployeesModule\Livewire\CreateEmployee::class);
            Livewire::component('employees.edit-employee', \App\Modules\EmployeesModule\Livewire\EditEmployee::class);
            Livewire::component('employees.manage-team-assignments', \App\Modules\EmployeesModule\Livewire\ManageTeamAssignments::class);
        }

        // Registrar observers
        Employee::observe(EmployeeObserver::class);
    }

    private function registerPolicies(): void {
        Gate::policy(Employee::class, EmployeePolicy::class);
    }

    private function loadViews(): void {
        $viewsPath = __DIR__ . '/../Resources/Views';
        $this->loadViewsFrom($viewsPath, 'employees');
    }
}
