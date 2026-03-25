<?php

declare(strict_types=1);

namespace App\Helpers;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;

/**
 * Helper institucional para la gestión de la navegación (Sidebar y Navbar).
 * [MEJORA]: Filtra automáticamente los elementos basados en permisos de Spatie/Gates.
 */
class MenuHelper {
    /**
     * Retorna la colección de elementos del menú lateral.
     */
    public static function getSidebarItems(): Collection {
        return collect([
            [
                'label' => __('Dashboard'),
                'icon' => 'home',
                'route' => 'dashboard',
                'pattern' => 'dashboard',
                'permission' => null, // Público para autenticados
            ],
            [
                'label' => __('Administración'),
                'icon' => 'cog-6-tooth',
                'permission' => 'users.view',
                'submenu' => [
                    [
                        'label' => __('Usuarios'),
                        'route' => 'users.index',
                        'pattern' => 'admin/users*',
                        'permission' => 'users.view',
                    ],
                    [
                        'label' => __('Roles y Permisos'),
                        'route' => 'roles.index',
                        'pattern' => 'admin/roles*',
                        'permission' => 'roles.view',
                    ],
                ],
            ],
            [
                'label' => __('Organización'),
                'icon' => 'building-office',
                'permission' => null, // Agrupador sin permiso específico
                'submenu' => [
                    [
                        'label' => __('Direcciones'),
                        'route' => 'organization.directorates.index',
                        'pattern' => 'organization/directorates*',
                        'permission' => 'directorates.viewAny',
                    ],
                    [
                        'label' => __('Departamentos'),
                        'route' => 'organization.departments.index',
                        'pattern' => 'organization/departments*',
                        'permission' => 'departments.viewAny',
                    ],
                    [
                        'label' => __('Equipos'),
                        'route' => 'organization.teams.index',
                        'pattern' => 'organization/teams*',
                        'permission' => 'teams.viewAny',
                    ],
                    [
                        'label' => __('Posiciones'),
                        'route' => 'organization.positions.index',
                        'pattern' => 'organization/positions*',
                        'permission' => 'positions.viewAny',
                    ],
                ],
            ],
            [
                'label' => __('Empleados'),
                'icon' => 'users',
                'permission' => 'employees.view',
                'submenu' => [
                    [
                        'label' => __('Lista de Empleados'),
                        'route' => 'employees.index',
                        'pattern' => 'employees*',
                        'permission' => 'employees.view',
                    ],
                ],
            ],
            // Los módulos adicionales pueden inyectar aquí sus menús
            // O podemos centralizar las llamadas a métodos estáticos de los módulos
        ])->filter(fn($item) => self::canView($item))
            ->map(fn($item) => self::processActiveStates($item));
    }

    /**
     * Verifica si el usuario actual tiene permiso para ver el elemento.
     */
    protected static function canView(array $item): bool {
        // Si no requiere permiso, es visible
        if (!isset($item['permission']) || empty($item['permission'])) {
            return true;
        }

        // Si tiene submenú, es visible si al menos un hijo es visible
        if (isset($item['submenu']) && !empty($item['submenu'])) {
            $visibleSubmenu = collect($item['submenu'])->filter(fn($sub) => self::canView($sub));
            return $visibleSubmenu->isNotEmpty();
        }

        return auth()->user()?->can($item['permission']) ?? false;
    }

    /**
     * Procesa recursivamente el estado activo basado en la ruta actual.
     */
    protected static function processActiveStates(array $item): array {
        // Limpiar submenú basado en permisos antes de marcar el estado activo del padre
        if (isset($item['submenu'])) {
            $item['submenu'] = collect($item['submenu'])
                ->filter(fn($sub) => self::canView($sub))
                ->map(fn($sub) => self::processActiveStates($sub))
                ->toArray();
        }

        $item['is_active'] = self::isActive($item);

        return $item;
    }

    /**
     * Determina si el elemento o alguno de sus hijos está activo.
     */
    protected static function isActive(array $item): bool {
        // Si tiene patrón específico
        if (isset($item['pattern']) && request()->is($item['pattern'])) {
            return true;
        }

        // Si la ruta coincide directamente
        if (isset($item['route']) && Route::currentRouteName() === $item['route']) {
            return true;
        }

        // Si algún hijo está activo
        if (isset($item['submenu'])) {
            return collect($item['submenu'])->contains(fn($sub) => self::isActive($sub));
        }

        return false;
    }
}
