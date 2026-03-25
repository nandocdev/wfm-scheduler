<?php

declare(strict_types=1);

namespace App\Modules\CommunicationsModule\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

/**
 * Proveedor de servicios para el módulo de comunicaciones.
 * Registra rutas, vistas y componentes dinámicos de la home.
 */
class CommunicationsServiceProvider extends ServiceProvider {
    /**
     * Registro del módulo.
     */
    public function boot(): void {
        // Rutas
        if (file_exists(__DIR__ . '/../Routes/web.php')) {
            $this->loadRoutesFrom(__DIR__ . '/../Routes/web.php');
        }

        // Vistas
        $this->loadViewsFrom(__DIR__ . '/../Resources/Views', 'communications');

        // Registro de componentes Livewire (Admin y Home)
        // Livewire::component('communications::news-list', \App\Modules\CommunicationsModule\Livewire\ListNews::class);
    }

    public function register(): void {
        // Implementación futura de servicios compartidos
    }
}
