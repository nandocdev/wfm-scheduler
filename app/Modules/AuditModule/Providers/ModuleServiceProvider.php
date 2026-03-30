<?php

namespace App\Modules\AuditModule\Providers;

use App\Modules\AuditModule\Models\AuditLog;
use App\Modules\AuditModule\Policies\AuditLogPolicy;
use App\Modules\AuditModule\Livewire\ListAuditLogs;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class ModuleServiceProvider extends ServiceProvider {
    public function boot(): void {
        $this->registerRoutes();
        $this->registerPolicies();
        $this->registerLivewireComponents();
        $this->loadViewsFrom(__DIR__ . '/../Resources/Views', 'audit');
    }

    private function registerRoutes(): void {
        Route::middleware(['web', 'auth', 'verified'])
            ->prefix('admin/audit')
            ->name('audit.')
            ->group(__DIR__ . '/../Routes/web.php');
    }

    private function registerPolicies(): void {
        Gate::policy(AuditLog::class, AuditLogPolicy::class);
    }

    private function registerLivewireComponents(): void {
        Livewire::component('audit.list-audit-logs', ListAuditLogs::class);
    }
}
