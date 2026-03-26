<?php

declare(strict_types=1);

namespace App\Modules\CommunicationsModule\Providers;

use App\Modules\CommunicationsModule\Models\News;
use App\Modules\CommunicationsModule\Models\Poll;
use App\Modules\CommunicationsModule\Models\Shoutout;
use App\Modules\CommunicationsModule\Observers\NewsObserver;
use App\Modules\CommunicationsModule\Observers\PollObserver;
use App\Modules\CommunicationsModule\Observers\ShoutoutObserver;
use App\Modules\CommunicationsModule\Policies\NewsPolicy;
use App\Modules\CommunicationsModule\Policies\PollPolicy;
use App\Modules\CommunicationsModule\Policies\ShoutoutPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

/**
 * Proveedor de servicios para el módulo de comunicaciones.
 * Registra rutas, vistas, políticas y componentes dinámicos.
 */
class ModuleServiceProvider extends ServiceProvider {
    /**
     * Registro del módulo.
     */
    public function boot(): void {
        $this->registerRoutes();
        $this->registerObservers();
        $this->registerPolicies();
        $this->registerLivewireComponents();
        $this->loadViews();
    }

    private function registerRoutes(): void {
        if (file_exists(__DIR__ . '/../Routes/web.php')) {
            $this->loadRoutesFrom(__DIR__ . '/../Routes/web.php');
        }
    }

    private function registerObservers(): void {
        News::observe(NewsObserver::class);
        Poll::observe(PollObserver::class);
        Shoutout::observe(ShoutoutObserver::class);
    }

    private function registerPolicies(): void {
        Gate::policy(News::class, NewsPolicy::class);
        Gate::policy(Poll::class, PollPolicy::class);
        Gate::policy(Shoutout::class, ShoutoutPolicy::class);
    }

    private function registerLivewireComponents(): void {
        // Componentes Livewire se registrarán aquí cuando se implementen
    }

    private function loadViews(): void {
        $this->loadViewsFrom(__DIR__ . '/../Resources/Views', 'communications');
    }

    public function register(): void {
        // Implementación futura de servicios compartidos
    }
}
