<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Modules\CoreModule\Models\Permission;
use App\Modules\CoreModule\Models\Role;
use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;

/**
 * Seeder institucional para la gestión de Roles y Permisos.
 * Centraliza la definición de capacidades por módulo.
 */
class RolesAndPermissionsSeeder extends Seeder {
    public function run(): void {
        config()->set('permission.cache.store', 'array');
        app()->forgetInstance(PermissionRegistrar::class);

        // Limpiar caché de permisos antes de iniciar
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        // 1. Permisos definidos explícitamente en el código actual
        $permissions = [
            // Core Module
            'users.view',
            'users.create',
            'users.edit',
            'users.delete',
            'roles.view',
            'roles.create',
            'roles.edit',

            // Organization Module
            'directorates.viewAny',
            'directorates.create',
            'directorates.update',
            'directorates.delete',
            'departments.viewAny',
            'departments.create',
            'departments.update',
            'departments.delete',
            'teams.viewAny',
            'teams.create',
            'teams.update',
            'teams.delete',
            'teams.members.viewAny',
            'teams.members.manage',
            'positions.viewAny',
            'positions.create',
            'positions.update',
            'positions.delete',

            // Employees Module
            'employees.view',
            'employees.view.others',
            'employees.view.all',
            'employees.create',
            'employees.edit',
            'employees.edit.others',
            'employees.edit.all',
            'employees.delete',
            'employees.delete.others',
            'employees.delete.all',
            'employees.force_delete',
            'employees.force_delete.others',
            'employees.force_delete.all',
            'employees.manageTeamAssignments',
            'employees.export',
            'employees.import',

            // Communications Module - Contenido
            'news.viewAny',
            'news.view',
            'news.create',
            'news.edit',
            'news.delete',
            'shoutouts.manage',
            'polls.manage',

            // Communications Module - Gestión
            'communications.manage',
            'communications.moderate',
            'communications.approve',
            'communications.reject',
            'communications.archive',
            'communications.view_pending',

            // Communications Module - Comentarios
            'comments.view',
            'comments.create',
            'comments.edit',
            'comments.delete',
            'comments.restore',
            'comments.force_delete',

            // Communications Module - Reacciones
            'reactions.view',
            'reactions.create',
            'reactions.edit',
            'reactions.delete',
            'reactions.restore',
            'reactions.force_delete',

            // Communications Module - Menciones
            'mentions.view',
            'mentions.create',
            'mentions.edit',
            'mentions.delete',
            'mentions.restore',
            'mentions.force_delete',

            // Communications Module - Notificaciones
            'notifications.view',
            'notifications.create',
            'notifications.edit',
            'notifications.delete',
            'notifications.restore',
            'notifications.force_delete',

            // Audit Module
            'audit.viewAny',
            'audit.export',
            'audit.prune',
        ];

        // Registro de permisos
        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web'
            ]);
        }

        // 2. Definición de Roles base
        $roles = [
            'operator' => ['name' => 'operator', 'code' => 'OP', 'level' => 1],
            'supervisor' => ['name' => 'supervisor', 'code' => 'SUP', 'level' => 2],
            'coordinator' => ['name' => 'coordinator', 'code' => 'COOR', 'level' => 3],
            'chief' => ['name' => 'chief', 'code' => 'JEF', 'level' => 4],
            'wfm' => ['name' => 'wfm', 'code' => 'WFM', 'level' => 5],
            'director' => ['name' => 'director', 'code' => 'DIR', 'level' => 6],
            'admin' => ['name' => 'admin', 'code' => 'ADM', 'level' => 99],
        ];

        foreach ($roles as $roleData) {
            Role::firstOrCreate(
                ['name' => $roleData['name'], 'guard_name' => 'web'],
                [
                    'code' => $roleData['code'],
                    'hierarchy_level' => $roleData['level']
                ]
            );
        }

        // 3. Asignación de permisos por rol
        foreach (['operator', 'supervisor', 'coordinator', 'chief', 'director'] as $roleName) {
            Role::findByName($roleName, 'web')->syncPermissions([]);
        }

        // Roles con acceso total / privilegiado
        $wfmRole = Role::findByName('wfm', 'web');
        $wfmRole->syncPermissions([
            'users.view',
            'users.create',
            'users.edit',
            'users.delete',
            'roles.view',
            'roles.create',
            'roles.edit',

            'directorates.viewAny',
            'directorates.create',
            'directorates.update',
            'directorates.delete',
            'departments.viewAny',
            'departments.create',
            'departments.update',
            'departments.delete',
            'teams.viewAny',
            'teams.create',
            'teams.update',
            'teams.delete',
            'teams.members.viewAny',
            'teams.members.manage',
            'positions.viewAny',
            'positions.create',
            'positions.update',
            'positions.delete',

            'employees.view',
            'employees.view.others',
            'employees.view.all',
            'employees.create',
            'employees.edit',
            'employees.edit.others',
            'employees.edit.all',
            'employees.delete',
            'employees.delete.others',
            'employees.delete.all',
            'employees.force_delete',
            'employees.force_delete.others',
            'employees.force_delete.all',
            'employees.manageTeamAssignments',
            'employees.export',

            'news.viewAny',
            'news.view',
            'news.create',
            'news.edit',
            'news.delete',
            'shoutouts.manage',
            'polls.manage',

            'communications.manage',
            'communications.moderate',
            'communications.approve',
            'communications.reject',
            'communications.archive',
            'communications.view_pending',

            'comments.view',
            'comments.create',
            'comments.edit',
            'comments.delete',
            'comments.restore',
            'comments.force_delete',

            'reactions.view',
            'reactions.create',
            'reactions.edit',
            'reactions.delete',
            'reactions.restore',
            'reactions.force_delete',

            'mentions.view',
            'mentions.create',
            'mentions.edit',
            'mentions.delete',
            'mentions.restore',
            'mentions.force_delete',

            'notifications.view',
            'notifications.create',
            'notifications.edit',
            'notifications.delete',
            'notifications.restore',
            'notifications.force_delete',

            'audit.viewAny',
            'audit.export',
            'audit.prune',
        ]);

        $adminRole = Role::findByName('admin', 'web');
        $adminRole->syncPermissions(Permission::all());

        // Limpiar caché final
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
