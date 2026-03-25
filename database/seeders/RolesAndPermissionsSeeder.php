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
            'positions.viewAny',
            'positions.create',
            'positions.update',
            'positions.delete',

            // Employees Module
            'employees.view',
            'employees.view.all',
            'employees.create',
            'employees.edit',
            'employees.edit.all',
            'employees.delete',
            'employees.delete.all',
            'employees.manageTeamAssignments',

            // Communications Module
            'news.viewAny',
            'news.view',
            'news.create',
            'news.update',
            'news.delete',
            'shoutouts.manage',
            'polls.manage',
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

        // Instrucción actual: WFM y Admin con acceso total
        $wfmRole = Role::findByName('wfm', 'web');
        $wfmRole->syncPermissions(Permission::all());

        $adminRole = Role::findByName('admin', 'web');
        $adminRole->syncPermissions(Permission::all());

        // Limpiar caché final
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
