<?php

namespace App\Modules\CoreModule\Providers;

use App\Modules\CoreModule\Actions\Fortify\CreateNewUser;
use App\Modules\CoreModule\Actions\Fortify\ResetUserPassword;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * El Proveedor de Servicios del Módulo Core (Identidad y Acceso).
     * Centraliza la lógica de autenticación (Fortify), roles y permisos.
     */

    public function register(): void
    {
        // Registro de bindings del módulo
    }

    public function boot(): void
    {
        // 1. Carga de infraestructura modular
        $this->registerInfrastructure();

        // 2. Configuración de Autenticación (Fortify)
        $this->configureFortify();

        // 3. Configuración de Rate Limiting
        $this->configureRateLimiting();
    }

    /**
     * Registra rutas, vistas y namespaces del módulo.
     */
    protected function registerInfrastructure(): void
    {
        if (file_exists(__DIR__ . '/../Routes/web.php')) {
            $this->loadRoutesFrom(__DIR__ . '/../Routes/web.php');
        }

        if (is_dir(__DIR__ . '/../Resources/Views')) {
            $this->loadViewsFrom(__DIR__ . '/../Resources/Views', 'core');
        }
    }

    /**
     * Configura las acciones y vistas de Laravel Fortify para el CoreModule.
     */
    protected function configureFortify(): void
    {
        // Configuración de Acciones
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
        Fortify::createUsersUsing(CreateNewUser::class);

        // Configuración de Vistas (Modularizadas bajo 'core::')
        Fortify::loginView(fn () => view('core::auth.login'));
        Fortify::verifyEmailView(fn () => view('core::auth.verify-email'));
        Fortify::twoFactorChallengeView(fn () => view('core::auth.two-factor-challenge'));
        Fortify::confirmPasswordView(fn () => view('core::auth.confirm-password'));
        Fortify::registerView(fn () => view('core::auth.register'));
        Fortify::resetPasswordView(fn () => view('core::auth.reset-password'));
        Fortify::requestPasswordResetLinkView(fn () => view('core::auth.forgot-password'));
    }

    /**
     * Configura el limitador de velocidad para login y 2FA.
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });
    }
}
