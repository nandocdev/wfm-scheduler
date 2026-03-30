<?php

declare(strict_types=1);

namespace App\Helpers;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth as AuthFacade;
use Illuminate\Support\Facades\Route as RouteFacade;

/**
 * Helper institucional para la gestión de la navegación (Sidebar y Navbar).
 * [MEJORA]: Filtra automáticamente los elementos basados en permisos de Spatie/Gates.
 */
class MenuHelper {
    /**
     * Usuario actual para verificación de permisos.
     */
    protected static $currentUser = null;
    /**
     * Retorna la colección de elementos del menú lateral.
     */
    public static function getSidebarItems($user = null): Collection {
        self::$currentUser = $user ?: AuthFacade::user();
        return collect([
            [
                'label' => __('Dashboard'),
                'icon' => 'home',
                'route' => 'dashboard',
                'pattern' => 'dashboard',
                'permission' => null, // Público para autenticados
            ],

            [
                'label' => __('Noticias'),
                'icon' => 'newspaper',
                'route' => 'home',
                'pattern' => 'news*',
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
                    [
                        'label' => __('Auditoría'),
                        'route' => 'audit.index',
                        'pattern' => 'admin/audit*',
                        'gate' => ['viewAny', \App\Modules\AuditModule\Models\AuditLog::class],
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
            [
                'label' => __('Programación'),
                'icon' => 'clock',
                'permission' => 'schedules.view',
                'submenu' => [
                    [
                        'label' => __('Plantillas de descanso'),
                        'route' => 'scheduling.break_templates.create',
                        'pattern' => 'scheduling/break-templates*',
                        'permission' => 'schedules.manage',
                    ],
                ],
            ],
            [
                'label' => __('Comunicaciones'),
                'icon' => 'chat-bubble-left-right',
                'permission' => 'news.viewAny',
                'submenu' => [
                    [
                        'label' => __('Noticias'),
                        'route' => 'communications.news.index',
                        'pattern' => 'admin/communications/news*',
                        'permission' => 'news.viewAny',
                    ],
                    [
                        'label' => __('Categorías'),
                        'route' => 'communications.admin.categories.index',
                        'pattern' => 'admin/communications/categories*',
                        'permission' => 'communications.manage',
                    ],
                    [
                        'label' => __('Etiquetas'),
                        'route' => 'communications.admin.tags.index',
                        'pattern' => 'admin/communications/tags*',
                        'permission' => 'communications.manage',
                    ],
                    [
                        'label' => __('Moderación'),
                        'route' => 'communications.moderation.index',
                        'pattern' => 'admin/communications/moderation*',
                        'permission' => 'communications.moderate',
                    ],
                ],
            ],
        ])->filter(fn($item) => self::canView($item))
            ->map(fn($item) => self::processActiveStates($item));
    }

    /**
     * Verifica si el usuario actual tiene permiso para ver el elemento.
     */
    protected static function canView(array $item): bool {
        $user = self::$currentUser ?: AuthFacade::user();

        // Si no requiere permiso ni gate, es visible para autenticados.
        if ((!isset($item['permission']) || empty($item['permission'])) && !isset($item['gate'])) {
            return (bool) $user;
        }

        // Permiso simple (legacy, Spatie name-based)
        if (isset($item['permission']) && !empty($item['permission'])) {
            return $user && $user->can($item['permission']);
        }

        // Gate específico (policy call like viewAny, update, etc.)
        if (isset($item['gate']) && is_array($item['gate']) && count($item['gate']) >= 1) {
            [$ability, $model] = $item['gate'] + [null, null];
            return $user && $user->can($ability, $model);
        }

        return false;
    }

    /**
     * Procesa recursivamente el estado activo basado en la ruta actual.
     */
    protected static function processActiveStates(array $item): array {
        // Si tiene submenú, procesar los hijos pero no filtrar nuevamente
        // ya que el filtrado se hace en el método getSidebarItems
        if (isset($item['submenu'])) {
            $item['submenu'] = collect($item['submenu'])
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
        if (isset($item['route']) && RouteFacade::currentRouteName() === $item['route']) {
            return true;
        }

        // Si algún hijo está activo
        if (isset($item['submenu'])) {
            return collect($item['submenu'])->contains(fn($sub) => self::isActive($sub));
        }

        return false;
    }
}
