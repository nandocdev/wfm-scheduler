<?php

declare(strict_types=1);

namespace App\Modules\CommunicationsModule\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

/**
 * Seeder para los permisos institucionales del módulo de comunicaciones.
 */
class CommunicationsPermissionSeeder extends Seeder {
    public function run(): void {
        $permissions = [
            'news.viewAny',
            'news.view',
            'news.create',
            'news.update',
            'news.delete',
            'shoutouts.manage',
            'polls.manage',
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission, 'web');
        }

        // Asignar al rol Admin si existe
        $adminRole = Role::where('name', 'Admin')->first();
        if ($adminRole) {
            $adminRole->givePermissionTo($permissions);
        }
    }
}
