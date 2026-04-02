<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class SchedulingPermissionsSeeder extends Seeder {
    public function run(): void {
        // Asegurar permisos necesarios para el módulo Scheduling
        Permission::firstOrCreate(['name' => 'schedules.assign']);
        Permission::firstOrCreate(['name' => 'schedules.manage']);
    }
}
