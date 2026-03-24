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
class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Limpiar caché de permisos antes de iniciar
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        // 1. Definición incremental de permisos (según docs/06_Permisos.md)
        $permissions = [
            // Auth & Profile
            'profile.view', 'profile.update', 'notifications.viewAny',

            // Security & Users
            'users.viewAny', 'users.view', 'users.create', 'users.update', 'users.delete',
            'roles.viewAny', 'roles.assign', 'permissions.viewAny', 'permissions.assign',

            // Organization & Corporate
            'directorates.viewAny', 'directorates.create', 'directorates.update',
            'departments.viewAny',  'departments.create',  'departments.update',
            'positions.viewAny',    'positions.create',    'positions.update',
            'hierarchy.viewAny',

            // Employee & Welfare
            'employees.viewAny', 'employees.view', 'employees.create',
            'employees.update',  'employees.import',
            'employees.welfare.view', 'employees.welfare.manage',
            'employees.own.view', 'employees.own.welfare.view',

            // Team Management
            'teams.viewAny', 'teams.create', 'teams.update',
            'teams.members.viewAny', 'teams.members.manage',

            // Schedule Engine
            'schedules.viewAny', 'schedules.create', 'schedules.update',
            'break_templates.viewAny', 'break_templates.create', 'break_templates.update',
            'wfm.config.manage',

            // Planning
            'weekly_schedules.viewAny', 'weekly_schedules.create',
            'weekly_schedules.update',  'weekly_schedules.publish',
            'weekly_schedules.team.view', 'weekly_schedules.own.view',
            'intraday_activities.viewAny', 'intraday_activities.create',
            'intraday_activities.update',  'intraday_activities.assign',
            'intraday_activities.own.view',
            'break_overrides.create',

            // Attendance & Incidents
            'attendance_incidents.viewAny', 'attendance_incidents.create',
            'attendance_incidents.update',  'attendance_incidents.own.view',
            'incidents.escalate',

            // Workflow — Permisos y Excepciones
            'leave_requests.create',       'leave_requests.view.own',
            'leave_requests.viewAny.team', 'leave_requests.approve',
            'leave_requests.reject',       'leave_requests.forceApply',
            'exceptions.create.direct',    'exceptions.create.bulk',
            'exceptions.forceApprove',     'exceptions.authorizeSpecial',

            // Workflow — Cambios de Turno
            'shift_swaps.create',        'shift_swaps.respond',
            'shift_swaps.viewAny.team',  'shift_swaps.approve',
            'shift_swaps.reject',

            // Analytics & Reporting
            'reports.team.view', 'reports.global.view',
            'reports.export',    'dashboard.kpi.view',

            // Administration & Audit
            'audit_logs.viewAny', 'system.reprocess',
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
            'operator'    => ['name' => 'operator', 'code' => 'OP', 'level' => 1],
            'supervisor'  => ['name' => 'supervisor', 'code' => 'SUP', 'level' => 2],
            'coordinator' => ['name' => 'coordinator', 'code' => 'COOR', 'level' => 3],
            'chief'       => ['name' => 'chief', 'code' => 'JEF', 'level' => 4],
            'wfm'         => ['name' => 'wfm', 'code' => 'WFM', 'level' => 5],
            'director'    => ['name' => 'director', 'code' => 'DIR', 'level' => 6],
            'admin'       => ['name' => 'admin', 'code' => 'ADM', 'level' => 99],
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

        // 3. Asignación masiva (Instrucción: Todos los permisos a WFM por ahora)
        $wfmRole = Role::findByName('wfm', 'web');
        $wfmRole->syncPermissions(Permission::all());

        $adminRole = Role::findByName('admin', 'web');
        $adminRole->syncPermissions(Permission::all());

        // Limpiar caché final
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
