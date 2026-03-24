<?php

namespace App\Modules\CoreModule\Providers;

use App\Modules\CoreModule\Actions\Fortify\CreateNewUser;
use App\Modules\CoreModule\Actions\Fortify\ResetUserPassword;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use Laravel\Fortify\Fortify;
use Livewire\Livewire;
use App\Modules\CoreModule\Models\User;
use App\Modules\CoreModule\Models\Role;
use App\Modules\CoreModule\Policies\UserPolicy;
use App\Modules\CoreModule\Policies\RolePolicy;

class ModuleServiceProvider extends ServiceProvider {
    /**
     * El Proveedor de Servicios del Módulo Core (Identidad y Acceso).
     * Centraliza la lógica de autenticación (Fortify), roles y permisos.
     */

    public function register(): void {
        // Registro de bindings del módulo
    }

    public function boot(): void {
        // 1. Carga de infraestructura modular
        $this->registerInfrastructure();

        // 2. Configuración de Autenticación (Fortify)
        $this->configureFortify();

        // 3. Configuración de Rate Limiting
        $this->configureRateLimiting();

        // 4. Autorización (RBAC)
        $this->registerPolicies();
    }

    /**
     * Registra las políticas de autorización del módulo.
     */
    protected function registerPolicies(): void {
        Gate::policy(User::class, UserPolicy::class);
        Gate::policy(Role::class, RolePolicy::class);
    }

    /**
     * Registra rutas, vistas y namespaces del módulo.
     */
    protected function registerInfrastructure(): void {
        $viewsPath = __DIR__ . '/../Resources/Views';

        if (file_exists(__DIR__ . '/../Routes/web.php')) {
            Route::middleware('web')->group(__DIR__ . '/../Routes/web.php');
        }

        if (is_dir($viewsPath)) {
            $this->loadViewsFrom($viewsPath, 'core');
            Blade::anonymousComponentPath($viewsPath, 'core');

            // Registro manual de componentes para control granular
            Livewire::component('core.users.list-users', \App\Modules\CoreModule\Livewire\Users\ListUsers::class);
            Livewire::component('core.users.create-user', \App\Modules\CoreModule\Livewire\Users\CreateUser::class);
            Livewire::component('core.users.edit-user', \App\Modules\CoreModule\Livewire\Users\EditUser::class);
            Livewire::component('core.roles.list-roles', \App\Modules\CoreModule\Livewire\Roles\ListRoles::class);
        }
    }

    /**
     * Configura las acciones y vistas de Laravel Fortify para el CoreModule.
     */
    protected function configureFortify(): void {
        // Configuración de Acciones
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
        Fortify::createUsersUsing(CreateNewUser::class);

        // Configuración de Vistas (Modularizadas bajo 'core::')
        Fortify::loginView(fn() => view('core::auth.login'));
        Fortify::verifyEmailView(fn() => view('core::auth.verify-email'));
        Fortify::twoFactorChallengeView(fn() => view('core::auth.two-factor-challenge'));
        Fortify::confirmPasswordView(fn() => view('core::auth.confirm-password'));
        Fortify::registerView(fn() => view('core::auth.register'));
        Fortify::resetPasswordView(fn() => view('core::auth.reset-password'));
        Fortify::requestPasswordResetLinkView(fn() => view('core::auth.forgot-password'));
    }

    /**
     * Configura el limitador de velocidad para login y 2FA.
     */
    protected function configureRateLimiting(): void {
        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())) . '|' . $request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });
    }
}
