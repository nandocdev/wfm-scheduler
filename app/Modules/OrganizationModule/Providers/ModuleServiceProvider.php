<?php

namespace App\Modules\OrganizationModule\Providers;

use App\Modules\OrganizationModule\Models\Directorate;
use App\Modules\OrganizationModule\Models\Department;
use App\Modules\OrganizationModule\Models\Position;
use App\Modules\OrganizationModule\Models\Team;
use App\Modules\OrganizationModule\Observers\DirectorateObserver;
use App\Modules\OrganizationModule\Observers\DepartmentObserver;
use App\Modules\OrganizationModule\Observers\PositionObserver;
use App\Modules\OrganizationModule\Observers\TeamObserver;
use App\Modules\OrganizationModule\Policies\DirectoratePolicy;
use App\Modules\OrganizationModule\Policies\DepartmentPolicy;
use App\Modules\OrganizationModule\Policies\PositionPolicy;
use App\Modules\OrganizationModule\Policies\TeamPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

/**
 * Registra todos los componentes del módulo Organization.
 * Este provider debe estar listado en bootstrap/providers.php (Laravel 11+)
 * o en config/app.php providers[] (Laravel 10).
 */
class ModuleServiceProvider extends ServiceProvider {
    public function boot(): void {
        $this->registerRoutes();
        $this->registerObservers();
        $this->registerPolicies();
        $this->loadViews();
    }

    private function registerRoutes(): void {
        Route::middleware('web')
            ->prefix('organization')
            ->name('organization.')
            ->group(__DIR__ . '/../Routes/web.php');
    }

    private function registerObservers(): void {
        Directorate::observe(DirectorateObserver::class);
        Department::observe(DepartmentObserver::class);
        Position::observe(PositionObserver::class);
        Team::observe(TeamObserver::class);
    }

    private function registerPolicies(): void {
        Gate::policy(Directorate::class, DirectoratePolicy::class);
        Gate::policy(Department::class, DepartmentPolicy::class);
        Gate::policy(Position::class, PositionPolicy::class);
        Gate::policy(Team::class, TeamPolicy::class);
    }

    private function loadViews(): void {
        $this->loadViewsFrom(
            __DIR__ . '/../Resources/Views',
            'organization'
        );
    }
}
