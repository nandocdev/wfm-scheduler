<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeamManagerSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        DB::transaction(function () {
            $this->seedTeams();
        });
    }

    private function seedTeams(): void {
        $teams = [
            [
                'id' => 1,
                'name' => 'Direccion',
                'description' => 'Equipo de desarrollo de software',
                'supervisor_id' => 1, // Asumiendo que el empleado con ID 1 existe
                'is_active' => true,
            ],
            [
                'id' => 2,
                'name' => 'Servicios al Asegurado',
                'description' => 'Equipo de diseño y UX/UI',
                'supervisor_id' => 2, // Asumiendo que el empleado con ID 2 existe
                'is_active' => true,
            ],
            [
                'id' => 3,
                'name' => 'Servicios para la Salud',
                'description' => 'Equipo de gestión de producto',
                'supervisor_id' => 3, // Asumiendo que el empleado con ID 3 existe
                'is_active' => true,
            ],
            [
                'id' => 4,
                'name' => 'Control y Monitoreo e Ingeniería',
                'description' => 'Equipo de control y monitoreo e ingeniería',
                'supervisor_id' => 4, // Asumiendo que el empleado con ID 4 existe
                'is_active' => true,
            ],
            [
                'id' => 5,
                'name' => 'Coordinacion 1',
                'description' => 'Equipo de coordinación 1',
                'supervisor_id' => 5, // Asumiendo que el empleado con ID 5 existe
                'is_active' => true,
            ],
            [
                'id' => 6,
                'name' => 'Coordinacion 2',
                'description' => 'Equipo de coordinación 2',
                'supervisor_id' => 6, // Asumiendo que el empleado con ID 6 existe
                'is_active' => true,
            ],
            [
                'id' => 7,
                'name' => 'Coordinacion 3',
                'description' => 'Equipo de coordinación 3',
                'supervisor_id' => 7, // Asumiendo que el empleado con ID 7 existe
                'is_active' => true,
            ],
            [
                'id' => 8,
                'name' => 'Coordinacion 4',
                'description' => 'Equipo de coordinación 4',
                'supervisor_id' => 8, // Asumiendo que el empleado con ID 8 existe
                'is_active' => true,
            ],
            [
                'id' => 9,
                'name' => 'Coordinacion 5',
                'description' => 'Equipo de coordinación 5',
                'supervisor_id' => 9, // Asumiendo que el empleado con ID 9 existe
                'is_active' => true,
            ],
            [
                'id' => 10,
                'name' => 'Coordinacion 6',
                'description' => 'Equipo de coordinación 6',
                'supervisor_id' => 10, // Asumiendo que el empleado con ID 10 existe
                'is_active' => true,
            ],
            [
                'id' => 11,
                'name' => 'Coordinacion 7',
                'description' => 'Equipo de coordinación 7',
                'supervisor_id' => 11, // Asumiendo que el empleado con ID 11 existe
                'is_active' => true,
            ],
            [
                'id' => 12,
                'name' => 'Coordinacion 8',
                'description' => 'Equipo de coordinación 8',
                'supervisor_id' => 12, // Asumiendo que el empleado con ID 12 existe
                'is_active' => true,
            ],
            [
                'id' => 13,
                'name' => 'Coordinacion 9',
                'description' => 'Equipo de coordinación 9',
                'supervisor_id' => 13, // Asumiendo que el empleado con ID 13 existe
                'is_active' => true,
            ],
        ];

        foreach ($teams as $team) {
            DB::table('teams')->updateOrInsert(
                ['id' => $team['id']],
                [
                    'name' => $team['name'],
                    'description' => $team['description'],
                    'supervisor_id' => $team['supervisor_id'],
                    'is_active' => $team['is_active'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        $this->command->info('Equipos sembrados exitosamente.');
    }
}
